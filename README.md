# CRM System

This is a simple CRM (Customer Relationship Management) system built with Laravel. It allows you to manage clients, projects, and tasks.

## Features

- **Client Management**: Add, edit, and delete clients.
- **Project Management**: Create, update, and delete projects. Assign projects to clients.
- **Task Management**: Track tasks associated with projects. Mark tasks as completed.
- **Role-Based Access Control (RBAC)**: Different user roles with varying levels of access to system functionalities.

## Technologies Used

- **Laravel**: A PHP framework for building web applications.
- **MySQL**: A relational database management system used for storing data.
- **JavaScript (Ajax)**: Used for dynamic updates and interactions on project-related pages.

> Note: For the sake of demonstrating different techniques, Ajax is used for handling projects, while web controllers are used for managing clients.

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

## Role-Based Access Control (RBAC)

- The system includes role-based access control, allowing different users to have varying levels of access to system functionalities based on their roles.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please feel free to open an issue or submit a pull request.

## License


