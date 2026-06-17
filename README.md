# Cosmic CatStudio

Cosmic CatStudio is a modular client-server platform designed to connect emerging musical artists with their audience. The software enables seamless media streaming, community interaction management, and an e-commerce ecosystem for exclusive merchandise monetization.

This system was engineered, structured, and fully documented under academic standards at the Universidad Autónoma del Estado de México (UAEMéx - UAP Tianguistenco).

---

## Featured Achievements
* **Software Fair Selection:** Chosen as one of the two exclusive projects representing the class to compete and exhibit at the university's Software Engineering Fair, outstanding for its architectural complexity, documentation quality, and system defense before the evaluation committee.

---

## Architecture & Technical Features
* **Relational Database Model:** Robust MySQL relational schema featuring 20 tables with strict referential integrity, primary/foreign keys, and junction tables designed to break down many-to-many (N:M) dependencies.
* **Modular Backend:** Server-side logic developed in PHP, segmented into autonomous modules handling specific workloads (User Management, Streaming Metrics, and E-commerce operations).
* **Media Assets Management:** Secure binary processing for local storage, buffering, and dynamic rendering of audio files and high-resolution image data.
* **Service Integrations:** Automated notification and recovery pipelines via SMTP utilizing the PHPMailer library, and transactional checkout processing integrated with the PayPal API.

---

## Tech Stack
* **Backend:** PHP (v7.4 / v8.0+)
* **Frontend:** JavaScript (Fetch API), HTML5, CSS3
* **Database:** MySQL / phpMyAdmin
* **Local Server:** XAMPP (Apache + MySQL stack)
* **Dependencies:** PHPMailer, PayPal SDK

---

## Repository Structure
* `/html`, `/js`, `/css`: Client-side UI layouts and web presentation components.
* `/php1`, `/php2`, `/php5`: Server-side modular microservices handling logic and DB querying.
* `/basedatos`: Production-ready SQL scripts containing full database schemas and structural assets.
* `/documentos`: Core system documentation including the Technical, User, and Installation manuals.

---

## Installation & Environment Setup
* **Web Server Environment:** XAMPP (Apache + PHP 7.4+ + MySQL).
* **Hardware Requirements:** 4 GB RAM minimum (8 GB recommended).
* **Critical Parameter Override:** Adjust the `max_allowed_packet = 16M` directive inside MySQL's `my.ini` configuration file to allow massive binary multimedia payload handling without connection drops.

*Note: Comprehensive step-by-step deployment guidelines, testing procedures, and rollback protocols in case of installation faults are thoroughly covered inside the Installation Manual located in the `/documentos` directory.*
