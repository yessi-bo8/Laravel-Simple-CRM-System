# CRM System

**Description:**
This is a basic CRM (Customer Relationship Management) system built using Laravel. It allows users to manage tasks, projects, and clients efficiently. The system features role-based authentication with Laravel's native role_user pivot table and utilizes Laravel Sanctum to protect routes.

**Key Features:**
- Create, update, and delete tasks, projects, and clients
- Role-based authentication (RBAC) system for secure access control
- Integration with Laravel Sanctum for route protection
- Clean data sending using Laravel resources and requests
- Demonstration of different data retrieval methods:
    - Projects: AJAX requests to ProjectApiController
    - Tasks: TaskWebController for sending task data and utilization of query scopes for task retrieval
    - Clients: Hybrid approach with initial data retrieval via WebController and subsequent updates using AJAX requests
- Includes factories and seeders for easy database seeding
- Seeders create an admin and a regular user for demonstration purposes

**Technologies Used:**
- Laravel framework
- Laravel Sanctum for API authentication
- MySQL database
- AJAX for dynamic data retrieval and updates
- PHP for server-side logic

> Please note that the decision to utilize both API and web controllers, sometimes in combination, for handling different resources is intentional. This approach has been chosen to showcase various techniques and methodologies rather than prioritizing efficiency.

## Getting Started

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/crm-system.git
   ```

2. Install dependencies:

   ```bash
   composer install
   npm install
   ```

3. Set up your environment variables by copying the `.env.example` file to `.env` and filling in the necessary details, such as database credentials.

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Run the database migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

6. Start the development server:

   ```bash
   php artisan serve
   ```

   Your CRM system should now be accessible at `http://localhost:8000`.

## Usage

- Navigate to the client management section to add, edit, and delete clients.
- Go to the project management section to create, update, and delete projects. You can also assign projects to clients here.
- Use the task management section to track tasks associated with projects. Mark tasks as completed when done.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please feel free to open an issue or submit a pull request.

## License


