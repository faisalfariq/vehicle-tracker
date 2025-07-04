# Physical Data Model: Pemesanan Kendaraan

Berikut adalah model data fisik (Physical Data Model) untuk fitur pemesanan kendaraan pada aplikasi Vehicle Tracker.

---

## Tabel Utama & Relasi

### 1. users
| Field         | Tipe         | Keterangan         |
|-------------- |--------------|-------------------|
| id            | BIGINT PK    | Primary key       |
| name          | VARCHAR      | Nama user         |
| email         | VARCHAR      | Email user        |
| password      | VARCHAR      | Password hash     |
| role_id       | BIGINT FK    | Relasi ke roles   |
| ...           | ...          | ...               |

### 2. roles
| Field         | Tipe         | Keterangan         |
|-------------- |--------------|-------------------|
| id            | BIGINT PK    | Primary key       |
| name          | VARCHAR      | Nama role (admin/user/approver) |

### 3. vehicles
| Field         | Tipe         | Keterangan         |
|-------------- |--------------|-------------------|
| id            | BIGINT PK    | Primary key       |
| name          | VARCHAR      | Nama kendaraan    |
| is_available  | BOOLEAN      | Status ketersediaan |
| ...           | ...          | ...               |

### 4. drivers
| Field         | Tipe         | Keterangan         |
|-------------- |--------------|-------------------|
| id            | BIGINT PK    | Primary key       |
| name          | VARCHAR      | Nama driver       |
| is_active     | BOOLEAN      | Status aktif      |
| ...           | ...          | ...               |

### 5. bookings
| Field           | Tipe         | Keterangan         |
|---------------- |--------------|-------------------|
| id              | BIGINT PK    | Primary key       |
| code            | VARCHAR      | Kode booking unik |
| user_id         | BIGINT FK    | User pemesan      |
| vehicle_id      | BIGINT FK    | Kendaraan         |
| driver_id       | BIGINT FK    | Driver            |
| start_datetime  | DATETIME     | Mulai pemakaian   |
| end_datetime    | DATETIME     | Selesai pemakaian |
| destination     | VARCHAR      | Tujuan            |
| reason          | TEXT         | Alasan            |
| status          | ENUM         | Status booking    |
| ...             | ...          | ...               |

### 6. booking_approvals
| Field         | Tipe         | Keterangan         |
|-------------- |--------------|-------------------|
| id            | BIGINT PK    | Primary key       |
| booking_id    | BIGINT FK    | Relasi ke bookings|
| approver_id   | BIGINT FK    | User approver     |
| level         | INT          | Level approval (1/2)|
| status        | ENUM         | pending/approved/rejected |
| approved_at   | DATETIME     | Tanggal approve   |

---

## Relasi Antar Tabel

- **users** (1) --- (N) **bookings** : Satu user bisa membuat banyak booking.
- **vehicles** (1) --- (N) **bookings** : Satu kendaraan bisa dipakai di banyak booking (tidak bersamaan).
- **drivers** (1) --- (N) **bookings** : Satu driver bisa dipakai di banyak booking.
- **bookings** (1) --- (N) **booking_approvals** : Satu booking memiliki dua approval (level 1 & 2).
- **users** (1) --- (N) **booking_approvals** : Satu user bisa menjadi approver di banyak approval.
- **roles** (1) --- (N) **users** : Satu role untuk banyak user.

---

## Penjelasan
- **users**: Menyimpan data pengguna (admin, approver, user biasa).
- **roles**: Menyimpan tipe role user.
- **vehicles**: Data kendaraan yang dapat dipesan.
- **drivers**: Data supir yang dapat dipilih.
- **bookings**: Data pemesanan kendaraan.
- **booking_approvals**: Data approval untuk setiap booking (level 1 & 2). 