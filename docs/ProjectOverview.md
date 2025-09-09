# Project Overview
## 1. System Objectives
- What problem are you solving?
  The Scholarship Management System aims to solve the challenges of manual, fragmented scholarship administration by providing a centralized, automated online platform for application, review, awarding, and fund disbursement. The system will reduce manual work, minimize errors, and improve transparency.

- Who benefits and how?
  Beneficiaries include students (who gain an accessible, streamlined application process and real-time updates), administrators and reviewers (who benefit from efficient management and decision-making tools), financial staff (who manage fund disbursement tracking), and donors/university administrators (who gain insights through reporting and analytics).

## 2. Proposed Scope
- Modules/systems to integrate (e.g., Auth, Payments, Messaging)
    Authentication module supporting role-based access and multi-factor authentication

    Student information systems (for academic data verification)

    Financial aid management systems (for scholarship fund disbursement tracking)

    External recommendation letter submission systems (if applicable)

    Messaging/email system for communications and notifications

- In-scope features for Lab 1–3
    Online application portal with customizable forms and document uploads

    Applicant eligibility verification and matching to scholarships

    Reviewer dashboard with scoring and comments

    Automated status notifications to applicants

    Administrator tools to create and manage scholarship programs

    Secure document storage and retrieval

    Basic reporting and dashboards

    Role-based user management and authentication

- Out-of-scope (for now)
    Financial accounting beyond scholarship disbursement

    Scholarship fundraising management

    Long-term academic performance tracking post-award, except for renewal eligibility

## 3. Stakeholders
    MinSU OSAS Staff — Need efficient management tools to process scholarships and minimize errors.

    MinSU Students (Applicants and Scholars) — Seek an intuitive application system with transparency on status and awards.

    MinSU University Administration — Interested in oversight, reporting, and fairness in scholarship distribution.

    MinSU College Deans and Faculty — Require involvement in eligibility and review processes.


## 4. Tools & Technologies
    Languages/Frameworks: Node.js (backend), Angular/Ionic (frontend), Firebase for authentication and real-time data management

    Integration Approach: REST APIs for linking with student information and financial aid systems; secure webhooks for external recommendation submissions

    Repos/Services: GitHub for version control; GitHub Actions for CI/CD pipelines

    Testing Tools: Jest for backend unit testing, Jasmine/Karma for Angular frontend testing, and Postman for API testing

    