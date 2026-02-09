# Job Portal API Documentation

## Base URL

```
http://localhost:8000/api
```

## Authentication

The API uses Laravel Sanctum for authentication. Include the token in the Authorization header:

```
Authorization: Bearer <your_token>
```

## Models

### User

```json
{
    "id": integer,
    "nama": string,
    "email": string,
    "role": "pencari kerja|recruiter|admin",
    "alamat": string|null,
    "tanggal_lahir": date|null,
    "jenis_kelamin": "L|P|null",
    "foto": string|null,           // path relatif file foto di storage
    "foto_url": string|null,       // URL akses publik ke foto (GET /storage/foto/namafile.jpg)
    "created_at": timestamp,
    "updated_at": timestamp
}
```

-   **foto**: path file di storage, misal: `foto/namafile.jpg`
-   **foto_url**: URL publik, misal: `http://localhost:8000/storage/foto/namafile.jpg`

### CV

```php
{
    "id": integer,
    "user_id": integer,
    "isi_cv": text,
    "created_at": timestamp,
    "updated_at": timestamp
}
```

### Pengalaman (Experience)

```php
{
    "id": integer,
    "user_id": integer,
    "institusi": string,
    "posisi": string,
    "lokasi": string,
    "tanggal_mulai": date,
    "tanggal_akhir": date|null,
    "deskripsi": text|null,
    "created_at": timestamp,
    "updated_at": timestamp
}
```

### Pendidikan (Education)

```php
{
    "id": integer,
    "user_id": integer,
    "institusi": string,
    "jenjang": enum["SD", "SMP", "SMA/SMK", "D1", "D2", "D3", "D4", "S1", "S2", "S3"],
    "jurusan": string,
    "lokasi": string,
    "tanggal_mulai": date,
    "tanggal_akhir": date|null,
    "ipk": decimal(3,2)|null,
    "deskripsi": text|null,
    "created_at": timestamp,
    "updated_at": timestamp
}
```

### Skill

```php
{
    "id": integer,
    "user_id": integer,
    "nama_skill": string,
    "level": enum["Beginner", "Intermediate", "Advanced", "Expert"],
    "sertifikasi": string|null,
    "created_at": timestamp,
    "updated_at": timestamp
}
```

## API Endpoints

### Authentication

#### Register

```http
POST /register
```

**Request Body (multipart/form-data):**
| Field | Type | Required | Description |
|-------------------|---------|----------|----------------------------|
| nama | string | yes | |
| email | string | yes | |
| password | string | yes | |
| password_confirmation | string | yes | |
| role | string | yes | pencari kerja/recruiter/admin |
| alamat | string | no | |
| tanggal_lahir | date | no | |
| jenis_kelamin | string | no | L/P |
| **foto** | file | no | Gambar profil (max 2MB) |

**Contoh request di Postman:**

-   Body: form-data
-   Key: `nama`, `email`, ... (text)
-   Key: `foto` (type: file, pilih file gambar)

**Response:**

-   Field `foto` dan `foto_url` akan muncul pada objek user jika upload berhasil.

#### Login

```http
POST /login
```

Request Body:

```json
{
    "email": "string",
    "password": "string"
}
```

#### Logout

```http
POST /logout
```

Requires Authentication: Yes

#### Get Profile

```http
GET /profile
```

Requires Authentication: Yes

#### Update Profile

```http
PUT /profile
```

**Request Body (multipart/form-data):**
| Field | Type | Required | Description |
|-------------------|---------|----------|----------------------------|
| nama | string | no | |
| alamat | string | no | |
| tanggal_lahir | date | no | |
| jenis_kelamin | string | no | L/P |
| current_password | string | required_with:new_password | |
| new_password | string | no | |
| new_password_confirmation | string | no | |
| **foto** | file | no | Gambar profil (max 2MB) |

**Catatan:**

-   Untuk upload file, gunakan `POST` + field `_method=PUT` jika client tidak support PUT multipart.

Requires Authentication: Yes

### CV Management

#### Get CV

```http
GET /cv
```

Requires Authentication: Yes

#### Create/Update CV

```http
POST /cv
```

Request Body:

```json
{
    "isi_cv": "string"
}
```

Requires Authentication: Yes

#### Generate CV with AI

```http
POST /cv/generate
```

Requires Authentication: Yes

#### Export CV to PDF

```http
GET /cv/export
```

Requires Authentication: Yes

#### Preview CV as PDF

```http
GET /cv/preview
```

Returns the CV as a PDF file with Content-Disposition set to 'inline' for browser preview.

Requires Authentication: Yes

#### Match Jobs (AI)

```http
POST /cv/match-jobs
```

Mencocokkan CV user dengan lowongan pekerjaan yang tersedia.

Request Body: _(opsional, tergantung implementasi AI)_

Requires Authentication: Yes

Response:

```json
{
    "status": true,
    "data": [
        {
            "job_id": 1,
            "score": 0.85,
            "job": {
                /* detail job */
            }
        }
    ]
}
```

#### Analyze Uploaded CV (AI)

```http
POST /cv/analyze-upload
```

Requires Authentication: Yes

**Deskripsi:**
Mengirim file CV untuk dianalisa oleh AI (misal: parsing otomatis, saran perbaikan, dsb).

**Request Body (multipart/form-data):**
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| file | file | yes | File CV (PDF/DOCX) |

**Response:**
Hasil analisa AI terhadap CV yang diupload.

---

#### Chat dengan AI tentang CV

```http
POST /cv/ai-chat
```

Requires Authentication: Yes

**Request Body (application/json):**

```json
{
    "message": "string", // Pertanyaan/instruksi ke AI
    "analysis": "string", // Hasil analisa dari endpoint /cv/analyze-upload
    "cvText": "string", // Teks CV hasil ekstrak dari file
    "language": "id|en" // (opsional)
}
```

**Response:**
Balasan AI terkait pertanyaan/instruksi tentang CV.

---

### Experience Management

#### List Experiences

```http
GET /pengalaman
```

Requires Authentication: Yes

#### Create Experience

```http
POST /pengalaman
```

Request Body:

```json
{
    "institusi": "string",
    "posisi": "string",
    "lokasi": "string",
    "tanggal_mulai": "date",
    "tanggal_akhir": "date|null",
    "deskripsi": "string|null"
}
```

Requires Authentication: Yes

#### Get Experience

```http
GET /pengalaman/{id}
```

Requires Authentication: Yes

#### Update Experience

```http
PUT /pengalaman/{id}
```

Request Body:

```json
{
    "institusi": "string",
    "posisi": "string",
    "lokasi": "string",
    "tanggal_mulai": "date",
    "tanggal_akhir": "date|null",
    "deskripsi": "string|null"
}
```

Requires Authentication: Yes

#### Delete Experience

```http
DELETE /pengalaman/{id}
```

Requires Authentication: Yes

### Education Management

#### List Education

```http
GET /pendidikan
```

Requires Authentication: Yes

#### Create Education

```http
POST /pendidikan
```

Request Body:

```json
{
    "institusi": "string",
    "jenjang": "SD|SMP|SMA/SMK|D1|D2|D3|D4|S1|S2|S3",
    "jurusan": "string",
    "lokasi": "string",
    "tanggal_mulai": "date",
    "tanggal_akhir": "date|null",
    "ipk": "decimal|null",
    "deskripsi": "string|null"
}
```

Requires Authentication: Yes

#### Get Education

```http
GET /pendidikan/{id}
```

Requires Authentication: Yes

#### Update Education

```http
PUT /pendidikan/{id}
```

Request Body:

```json
{
    "institusi": "string",
    "jenjang": "SD|SMP|SMA/SMK|D1|D2|D3|D4|S1|S2|S3",
    "jurusan": "string",
    "lokasi": "string",
    "tanggal_mulai": "date",
    "tanggal_akhir": "date|null",
    "ipk": "decimal|null",
    "deskripsi": "string|null"
}
```

Requires Authentication: Yes

#### Delete Education

```http
DELETE /pendidikan/{id}
```

Requires Authentication: Yes

### Skills Management

#### List Skills

```http
GET /skills
```

Requires Authentication: Yes

#### Create Skill

```http
POST /skills
```

Request Body (multipart/form-data):

```json
{
    "nama_skill": "string",
    "level": "Beginner|Intermediate|Advanced|Expert",
    "sertifikasi": "file|null"
}
```

Requires Authentication: Yes

#### Get Skill

```http
GET /skills/{id}
```

Requires Authentication: Yes

#### Update Skill

```http
PUT /skills/{id}
```

Request Body (multipart/form-data):

```json
{
    "nama_skill": "string",
    "level": "Beginner|Intermediate|Advanced|Expert",
    "sertifikasi": "file|null"
}
```

Requires Authentication: Yes

#### Delete Skill

```http
DELETE /skills/{id}
```

Requires Authentication: Yes

### Scraped Jobs

#### List Jobs

```http
GET /jobs
```

Query Params (opsional): `keyword`, `location`, `company`

Response: Pagination object berisi list job hasil scraping.

#### Get Job Detail

```http
GET /jobs/{id}
```

Response: Detail job hasil scraping.

## Response Format

### Success Response

```json
{
    "status": true,
    "message": "string",
    "data": object|array|null
}
```

### Error Response

```json
{
    "status": false,
    "message": "string",
    "errors": object|null
}
```

## Error Codes

-   200: Success
-   201: Created
-   400: Bad Request
-   401: Unauthorized
-   403: Forbidden
-   404: Not Found
-   422: Validation Error
-   500: Server Error
