Task List for the project:

- [x] Task 1: Set Up the Laravel Project
Create a new Laravel project using the Laravel Installer.
Set up your development environment.

- [x] Task 2: Create the Database Schema
Create a database table to sre form submission data (e.g., company_submissions).
Define the table columns based on the form fields.


- [x] Task 3: Create the CompanyController
Create a controller named CompanyController to handle the form submission and other actions.
Define the necessary routes for the controller.

- [x] Task 4: Create the Form View
Create a Blade view to display the form.
Add the Company Symbol, Start Date, End Date, and Email fields to the form.
Include client-side validation using jQuery UI datepicker for date fields.

- [x] Task 5: Fetch Company Symbols
Fetch the available company symbols from the provided JSON file (https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json).
Pass the symbols to the form view and populate the Company Symbol field as a dropdown.
    - [x] Refactor to seeder | apply caching.

- [x] Task 6: Server-Side Validation
Implement server-side validation in the CompanyController for the form data.
Validate Company Symbol, Start Date, End Date, and Email based on the specified rules.
Display appropriate validation error messages.

- [x] Task 7: Historical Data Retrieval
Implement code in the CompanyController to retrieve historical data using the provided API (https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data).
Use the Company Symbol and date range from the form submission.
Set up the necessary header parameters (X-RapidAPI-Key and X-RapidAPI-Host).

- [x] Task 8: Display Historical Data in Table
Create a view in Laravel to display historical data in tabular format (table columns: Date, Open, High, Low, Close, Volume).
Pass the retrieved historical data to the view.
    - [ ] Refactor to a service
- [x] Task 9: Create a Chart
Integrate a chart library like Chart.js (https://www.chartjs.org/) into your Laravel application.
Generate a chart based on the Open and Close prices from the retrieved historical data.
Display the chart in the view.

- [x] Task 10: Email Submission Data
Implement code in the CompanyController to send an email to the submitted email address.
Use the company's name as the email subject (retrieved from the Company Symbol).
Include the Start Date and End Date in the email body.

- [x] Task 11: Testing
Write unit tests for your application, covering both backend and frontend.
Ensure you have good test coverage (aim for 100%).

- [x] Task 12: Bonus (Optional)
Containerize your Laravel application using Docker.
Consider using Dependency Injection where applicable.
Continue to improve test coverage to reach 100%.

- [x] Task 13: GitHub Repository
Create a GitHub repository for your project.
Share the repository with the provided GitHub account (phpinterviews@trading-point.com).