

# Employee–Department–Project API

A simple **PHP + MySQL REST API** to manage employees, departments, and projects.
Supports **CRUD operations**, **relationship queries**, and **analytics queries**.


## **Table of Contents**

* [Features](#features)
* [Requirements](#requirements)
* [Database Setup](#database-setup)
* [API Endpoints](#api-endpoints)
* [Usage](#usage)

---

## **Features**

* Create, Read, Update, Delete employees, departments, and projects
* Retrieve all employees in a department
* Retrieve all projects in a department
* Analytics:

  * Total employees per department
  * Average salary per department
  * Total projects per department

---

## **Requirements**

* PHP 7.4+
* MySQL / MariaDB
* Web server (XAMPP, WAMP, LAMP, etc.)

---

## **Database Setup**

1. Create a database:

```sql
CREATE DATABASE EmployeeManagementSystem;
```

2. Create tables:

```sql
--departments table
CREATE TABLE departments (
	department_id SERIAL PRIMARY KEY,
	department_name VARCHAR(100) NOT NULL
);

--employees table
CREATE TABLE employees(
	employee_id SERIAL PRIMARY KEY,
	employee_name VARCHAR(100) NOT NULL,
	salary DECIMAL(10,2),
	department_id INT,
	FOREIGN KEY (department_id)
	REFERENCES departments(department_id)
);

--projects table
CREATE TABLE projects(
	project_id SERIAL PRIMARY KEY,
	project_name VARCHAR(100),
	department_id INT,
	FOREIGN KEY (department_id)
	REFERENCES departments(department_id)
);
```

3. Optionally, insert sample data:

```sql
INSERT INTO departments VALUES
(1,'HR'),
(2,'IT'),
(3,'Finance');

INSERT INTO employees(employee_name,salary,department_id) VALUES
('CARLO',100000,2),
('KIEL',150000,2),
('JOAQUIN',50000,3),
('JERICHO',67000,1);

insert into projects (project_name,department_id) VALUES 
('Payroll System',1),
('Website Development',2),
('Accounting System',3);
```

---

## **API Endpoints**

### **Employees**

| Endpoint                                 | Method | Description                   |
| ---------------------------------------- | ------ | ----------------------------- |
| `/employees.php`                         | GET    | Get all employees             |
| `/employees.php?id={id}`                 | GET    | Get employee by ID            |
| `/employees.php?department_id={dept_id}` | GET    | Get employees in a department |
| `/employees.php`                         | POST   | Add new employee              |
| `/employees.php?id={id}`                 | PUT    | Update employee               |
| `/employees.php?id={id}`                 | DELETE | Delete employee               |

### **Projects**

| Endpoint                                | Method | Description                  |
| --------------------------------------- | ------ | ---------------------------- |
| `/projects.php`                         | GET    | Get all projects             |
| `/projects.php?id={id}`                 | GET    | Get project by ID            |
| `/projects.php?department_id={dept_id}` | GET    | Get projects in a department |
| `/projects.php`                         | POST   | Add new project              |
| `/projects.php?id={id}`                 | PUT    | Update project               |
| `/projects.php?id={id}`                 | DELETE | Delete project               |

### **Analytics**

| Endpoint         | Method | Description                                                           |
| ---------------- | ------ | --------------------------------------------------------------------- |
| `/analytics.php` | GET    | Get employees per department, average salary, projects per department |

---

## **Usage**

1. Place all PHP files (`db.php`, `employees.php`, `departments.php`, `projects.php`, `analytics.php`) in your web server directory.
2. Update **database credentials** in `db.php`.
3. Use a tool like **Postman** or your browser to test endpoints.

Example:

```bash
GET http://localhost/employees.php
GET http://localhost/employees.php?department_id=2
POST http://localhost/employees.php
{
  "employee_name": "Mike",
  "salary": 40000,
  "department_id": 2
}
