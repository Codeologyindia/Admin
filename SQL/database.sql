-- Table: rol
CREATE TABLE rol (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Table: login
CREATE TABLE login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol_id INT,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (rol_id) REFERENCES rol(id)
);

-- Table: sessions (for Laravel session driver)
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL
);

-- Table: hospitals
CREATE TABLE hospitals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_name VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    contact VARCHAR(50) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);


-- Master: states
CREATE TABLE states (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL
);

-- Master: cities
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL
);
 
-- Master: districts
CREATE TABLE districts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL
);


-- Table: doctors
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    hospital_id INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id)
);

-- Table: departments
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Table: ref_persons
CREATE TABLE ref_persons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    number VARCHAR(30) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    referral_system VARCHAR(50) DEFAULT NULL,
    id_set JSON DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Table: other_documents
CREATE TABLE other_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    id_set JSON DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Table: madison_quaries
CREATE TABLE madison_quaries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ref_person_id INT DEFAULT NULL,
    patient_title VARCHAR(10) DEFAULT NULL,
    patient_name VARCHAR(100) NOT NULL,
    gender VARCHAR(10) DEFAULT NULL,
    dob DATE DEFAULT NULL,
    guardian_name VARCHAR(100) DEFAULT NULL,
    mobile VARCHAR(20) DEFAULT NULL,
    alternate_number VARCHAR(20) DEFAULT NULL,
    problam VARCHAR(255) DEFAULT NULL,
    doctor_ids JSON DEFAULT NULL,
    hospital_ids JSON DEFAULT NULL,
    department_ids JSON DEFAULT NULL,
    state_id INT DEFAULT NULL,
    city_id INT DEFAULT NULL,
    district_id INT DEFAULT NULL,
    village VARCHAR(100) DEFAULT NULL,
    block VARCHAR(100) DEFAULT NULL,
    pin_code VARCHAR(20) DEFAULT NULL,
    aadhaar_number VARCHAR(30) DEFAULT NULL,
    madison_upload VARCHAR(255) DEFAULT NULL,
    amount DECIMAL(10,2) DEFAULT NULL,
    paid_amount DECIMAL(10,2) DEFAULT NULL,
    payment_id VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Table: payment_logs
CREATE TABLE payment_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    madison_quary_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_id VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (madison_quary_id) REFERENCES madison_quaries(id)
);

-- Table: ayasman_card
CREATE TABLE ayasman_card (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ref_person_name VARCHAR(100) DEFAULT NULL,
    ref_person_number VARCHAR(30) DEFAULT NULL,
    ref_person_address VARCHAR(255) DEFAULT NULL,
    referral_system VARCHAR(50) DEFAULT NULL,
    patient_name VARCHAR(100) NOT NULL,
    title VARCHAR(20) DEFAULT NULL,
    guardian_name VARCHAR(100) DEFAULT NULL,
    dob DATE DEFAULT NULL,
    gender VARCHAR(10) DEFAULT NULL,
    mobile VARCHAR(20) DEFAULT NULL,
    problam VARCHAR(255) DEFAULT NULL,
    doctor_names JSON DEFAULT NULL,
    hospital_names JSON DEFAULT NULL,
    department_names JSON DEFAULT NULL,
    state VARCHAR(100) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    district VARCHAR(100) DEFAULT NULL,
    village VARCHAR(100) DEFAULT NULL,
    block VARCHAR(100) DEFAULT NULL,
    pin_code VARCHAR(20) DEFAULT NULL,
    aadhaar_number VARCHAR(30) DEFAULT NULL,
    ayushman_number VARCHAR(50) DEFAULT NULL,
    other_documents JSON DEFAULT NULL,
    ayushman_upload VARCHAR(255) DEFAULT NULL,
    amount DECIMAL(10,2) DEFAULT 0,
    paid_amount DECIMAL(10,2) DEFAULT 0,
    payment_id VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Table: ayasman_payment_logs
CREATE TABLE ayasman_payment_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ayasman_card_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_id VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (ayasman_card_id) REFERENCES ayasman_card(id)
);

-- Table: booking_online
CREATE TABLE booking_online (
    id INT AUTO_INCREMENT PRIMARY KEY,
    person_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    alternate_number VARCHAR(20) DEFAULT NULL,
    dob DATE DEFAULT NULL,
    gender VARCHAR(10) DEFAULT NULL,
    state_id INT DEFAULT NULL,
    city_id INT DEFAULT NULL,
    district_id INT DEFAULT NULL,
    new_state VARCHAR(100) DEFAULT NULL,
    new_city VARCHAR(100) DEFAULT NULL,
    new_district VARCHAR(100) DEFAULT NULL,
    hospital_id INT DEFAULT NULL,
    new_hospital VARCHAR(255) DEFAULT NULL,
    department_id INT DEFAULT NULL,
    new_department VARCHAR(255) DEFAULT NULL,
    problem VARCHAR(255) DEFAULT NULL,
    appointment_date DATE DEFAULT NULL,
    appointment TIME DEFAULT NULL,
    amount DECIMAL(10,2) DEFAULT NULL,
    paid_amount DECIMAL(10,2) DEFAULT NULL,
    payment_id VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Table: booking_payment_logs
CREATE TABLE booking_payment_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_online_id INT NOT NULL,
    paid_amount DECIMAL(10,2) NOT NULL,
    payment_id VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (booking_online_id) REFERENCES booking_online(id)
);

-- Table: query_types
CREATE TABLE query_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Insert default query types
INSERT INTO query_types (name, slug, created_at) VALUES
('Madison Related', 'madison', NOW()),
('Ayushman Card Related', 'ayushman', NOW());
