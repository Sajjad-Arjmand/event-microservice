# Event Management Microservice

This microservice provides APIs to store and retrieve events with pagination.

## **Installation**

### **1. Clone the Repository**

```bash
git clone https://github.com/Sajjad-Arjmand/event-microservice.git
cd event-microservice
```

### **2. Install Dependencies**

```bash
composer install
```

### **3. Configure Environment**

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

Then, update database credentials in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=events_db
DB_USERNAME=root
DB_PASSWORD=root
```

### **4. Run Database Migrations**

```bash
php artisan migrate
```

### **5. Generate Application Key**

```bash
php artisan key:generate
```

```bash
php artisan migrate
```

### **6. Start the Server**

```bash
php artisan serve
```

Server will start on `http://127.0.0.1:8000`

## **Docker Setup**

### **Run with Docker**

```bash
docker-compose up --build -d
```

The app will be available at `http://localhost:8000`

## **API Endpoints**

### **1. Store Event**

- **Endpoint:** `POST /api/v1/event`
- **Request Body:**

```json
{
  "user_id": 12345,
  "event_name": "button_clicked",
  "payload": {"key": "value"}
}
```

- **Response:**

```json
{
  "success": true,
  "event_id": 1
}
```

### **2. Get Events**

- **Endpoint:** `GET /api/v1/events`
- **Query Parameters:**
  - `from` (date, optional)
  - `limit` (int, optional)
  - `page` (int, optional)
  - `user_id` (int, optional)
- **Example Request:**

```bash
GET /api/v1/events?user_id=12345&limit=10&page=1
```

- **Response:**

```json
{
  "data": [
    {
      "id": 1,
      "user_id": 12345,
      "event_name": "button_clicked",
      "payload": {"key": "value"},
      "created_at": "2025-01-13T12:00:00Z"
    }
  ]
}
```

## **Running Tests**

Run the tests using:

```bash
php artisan test
```

