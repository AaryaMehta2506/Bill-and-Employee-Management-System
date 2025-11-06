# Bill and Employee Management System

## Overview
This project is a web-based Employee and Bill Management System developed. It provides secure user authentication, employee management, and dynamic bill entry features. The system is built with PHP, JavaScript, jQuery, AJAX, Bootstrap, HTML, CSS, and Microsoft SQL Server.

## Features
- User Authentication: Login and registration pages with database connectivity and role-based access.
- Dashboard: Responsive admin dashboard integrating employee and bill modules.
- Employee Management: DataTable to display employee details with Add, Edit, and Soft Delete options; image upload with filename stored in the database; is_delete soft delete flag; audit fields (created_at, created_by, updated_at, updated_by).
- Bill Management: Bill head and detail tables linked by bill_id; automatic detail-row generation based on quantity; editable item rows with add/remove icons; soft delete for bill items (is_delete = 1); automatic recalculation of bill quantity when detail rows change; file upload handling that preserves existing filenames when no new file is provided; stable ordering with ORDER BY bill_id ASC.
- UI/UX Enhancements: Responsive Bootstrap 5 layout, Cancel button beside Save/Update, and consistent styling across modules.

## Technologies Used
- Frontend: HTML, CSS, Bootstrap 5, JavaScript, jQuery, AJAX
- Backend: PHP
- Database: Microsoft SQL Server

## Key Learnings
- Integrated PHP with Microsoft SQL Server for CRUD operations and authentication.
- Implemented dynamic forms and DataTables using jQuery and AJAX.
- Designed soft delete mechanisms and audit tracking for reliable data management.
- Improved UI/UX for better usability in enterprise web applications.

## How to Run
1. Clone the repository.
2. Create the Microsoft SQL Server database and tables using the provided schema.
3. Configure database connection settings in the PHP configuration files.
4. Place the project in your web server root (e.g., XAMPP/WAMP www or htdocs) and start the server.
5. Open the application in your browser at http://localhost/your_project_folder/

## Output:
<img width="1919" height="899" alt="Screenshot 2025-11-06 161304" src="https://github.com/user-attachments/assets/26146529-6faa-4b7d-8bdf-f3e9e72d4b37" />
<img width="1919" height="894" alt="Screenshot 2025-11-06 161848" src="https://github.com/user-attachments/assets/a34bca83-3895-4083-b041-ce6ec332e917" />
<img width="1919" height="909" alt="Screenshot 2025-11-06 161232" src="https://github.com/user-attachments/assets/2c946421-7250-4aa2-b4f0-59f382078b7c" />
<img width="1919" height="907" alt="Screenshot 2025-11-06 161331" src="https://github.com/user-attachments/assets/aea1cb15-99c0-4565-b627-2fd304ca4df4" />
<img width="1919" height="898" alt="Screenshot 2025-11-06 161341" src="https://github.com/user-attachments/assets/3c54eba5-283c-4230-bc78-bbbf6b38995a" />
<img width="1919" height="885" alt="Screenshot 2025-11-06 161351" src="https://github.com/user-attachments/assets/8ea7573d-bb1e-4b41-9f92-eaed198eccab" />
<img width="1916" height="895" alt="Screenshot 2025-11-06 161404" src="https://github.com/user-attachments/assets/fdc6c3ea-66d9-4a22-b19d-32b4047b18a5" />
<img width="1917" height="899" alt="Screenshot 2025-11-06 161414" src="https://github.com/user-attachments/assets/c4b20327-5308-4fd7-9b4f-de2664a800dd" />
<img width="1919" height="894" alt="Screenshot 2025-11-06 161543" src="https://github.com/user-attachments/assets/848e5909-0837-4b0a-8605-63f17e50137b" />
<img width="1919" height="1009" alt="Screenshot 2025-11-06 161812" src="https://github.com/user-attachments/assets/089cb7c9-de85-46ad-96de-9ed73a36db36" />

## Contributing
Contributions are welcome!
Feel free to fork the repository, improve the game, and open a pull request. Let's grow this classic game together!

## License
This project is licensed under the [![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](./LICENSE)

## Author
**Aarya Mehta**  
🔗 [GitHub Profile](https://github.com/AaryaMehta2506)
