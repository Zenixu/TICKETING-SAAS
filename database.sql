-- ============================================================================
-- SUPABASE POSTGRESQL PRODUCTION DDL SCHEMA (PRODUCTION READY)
-- Platform: SaaS TiketKita (Community Ticketing & Event Management)
-- Date Updated: 2026-08-04
-- Architecture: Bounded Context Relational Schema with Row-Level Security (RLS)
-- ============================================================================

-- 1. EXTENSIONS & CLEANUP
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

DROP TABLE IF EXISTS feedbacks CASCADE;
DROP TABLE IF EXISTS attendees CASCADE;
DROP TABLE IF EXISTS event_payments CASCADE;
DROP TABLE IF EXISTS events CASCADE;
DROP TABLE IF EXISTS personal_access_tokens CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- 2. USERS TABLE (Identity & RBAC)
CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(20) NOT NULL DEFAULT 'user' CHECK (role IN ('user', 'organizer', 'admin')),
    organizer_status VARCHAR(20) NOT NULL DEFAULT 'none' CHECK (organizer_status IN ('none', 'pending', 'approved', 'rejected')),
    email_verified_at TIMESTAMP WITH TIME ZONE NULL,
    password VARCHAR(255) NULL, -- Nullable for Google OAuth users
    google_oauth_token TEXT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for Users
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_organizer_status ON users(organizer_status);

-- 3. EVENTS TABLE (Core Event Domain)
CREATE TABLE events (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date_time TIMESTAMP WITH TIME ZONE NOT NULL,
    google_calendar_event_id VARCHAR(255) NULL,
    location_name VARCHAR(255) NOT NULL,
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'draft' CHECK (status IN ('draft', 'pending_payment', 'active', 'completed', 'cancelled')),
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    quota INT NOT NULL DEFAULT 0,
    certificate_template_path VARCHAR(255) NULL,
    material_links JSONB NULL,
    created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for Events
CREATE INDEX idx_events_user_id ON events(user_id);
CREATE INDEX idx_events_status ON events(status);
CREATE INDEX idx_events_date_time ON events(date_time);

-- 4. EVENT_PAYMENTS TABLE (License Fee & Financial Domain)
CREATE TABLE event_payments (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    event_id UUID NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    transaction_id VARCHAR(255) NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL DEFAULT 'qris',
    payment_status VARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (payment_status IN ('pending', 'settled', 'failed', 'expired')),
    paid_at TIMESTAMP WITH TIME ZONE NULL,
    created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for Event Payments
CREATE INDEX idx_event_payments_event_id ON event_payments(event_id);
CREATE INDEX idx_event_payments_status ON event_payments(payment_status);

-- 5. ATTENDEES TABLE (Ticketing & Check-in Domain)
CREATE TABLE attendees (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    event_id UUID NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    user_id UUID NULL REFERENCES users(id) ON DELETE SET NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NULL,
    qr_code_token VARCHAR(255) NOT NULL UNIQUE,
    status VARCHAR(20) NOT NULL DEFAULT 'registered' CHECK (status IN ('registered', 'checked_in', 'cancelled')),
    checked_in_at TIMESTAMP WITH TIME ZONE NULL,
    created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for Attendees
CREATE INDEX idx_attendees_event_id ON attendees(event_id);
CREATE INDEX idx_attendees_user_id ON attendees(user_id);
CREATE INDEX idx_attendees_qr_code_token ON attendees(qr_code_token);
CREATE INDEX idx_attendees_status ON attendees(status);

-- 6. FEEDBACKS TABLE (Post-Event & Certificate Domain)
CREATE TABLE feedbacks (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    attendee_id UUID NOT NULL REFERENCES attendees(id) ON DELETE CASCADE,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review TEXT NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for Feedbacks
CREATE INDEX idx_feedbacks_attendee_id ON feedbacks(attendee_id);

-- 7. PERSONAL ACCESS TOKENS (Sanctum Auth Integration)
CREATE TABLE personal_access_tokens (
    id BIGSERIAL PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT NULL,
    last_used_at TIMESTAMP WITH TIME ZONE NULL,
    expires_at TIMESTAMP WITH TIME ZONE NULL,
    created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_pat_tokenable ON personal_access_tokens(tokenable_type, tokenable_id);

-- 8. ROW LEVEL SECURITY (RLS) POLICIES FOR SUPABASE SECURITY
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE events ENABLE ROW LEVEL SECURITY;
ALTER TABLE event_payments ENABLE ROW LEVEL SECURITY;
ALTER TABLE attendees ENABLE ROW LEVEL SECURITY;
ALTER TABLE feedbacks ENABLE ROW LEVEL SECURITY;

-- Default Read-Public Policies
CREATE POLICY "Public Events Visibility" ON events FOR SELECT USING (status = 'active');
CREATE POLICY "Public Users Self Access" ON users FOR ALL USING (auth.uid() = id);

-- ============================================================================
-- END OF SUPABASE DDL SCHEMA
-- ============================================================================
