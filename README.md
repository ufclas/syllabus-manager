UFCLAS Syllabus Manager
=======================

(In development) Manages custom post types, taxonomies, and metadata for the CLAS Syllabus website.

Installation
-------------

Download and unzip files into a folder named 'ufclas-syllabus-manager' in the plugins directory. Activate plugin in your site.


Requirements and Suggested Plugins
-----------------------------------

### Required
- UFCLAS UFL 2015 Theme (untested with other themes)
- LH User Taxonomies - allows setting departments for users

### Recommended
- Advanced Custom Fields - visual interface for custom fields
- Admin Columns Pro - allows custom display, advanced filtering of uploads, and inline editing
- GM Media Tags - adds ability to bulk add taxonomies for multiple documents


Documentation
--------------

### Custom Post Types and Taxonomies

See [Syllabus_Manager_Post_Type](https://github.com/ufclas/ufclas-syllabus-manager/blob/develop/includes/class-syllabus-manager-post-type.php)

- Courses (syllabus_course)
- Instructors (syllabus_instructor)
- Departments (syllabus_department)
- Program Levels (syllabus_level)
- Semesters (syllabus_semesters)

#### Departments (syllabus_department)

Term Meta:

- sm_department_id - department code
- sm_department_cover - cover image url for the department page
- sm_department_website - attachment id used for department website

Commands:

Update a department term via WP-CLI

```
wp term update syllabus_department <TERM_ID> --slug='<TERM_SLUG>'
wp term meta add 161 sm_department_id '<DEPT_ID>'
wp term meta add 161 sm_department_website '<DEPT_WEBSITE>'
wp term meta add 161 sm_department_cover <DEPT_COVER>
wp term update syllabus_department 219 --slug='akan' --parent=218 --name='Akan'
```

Update a sub department via WP-CLI

```
wp term update syllabus_department <TERM_ID> --slug='<SLUG>' --parent=<PARENT_TERM_ID> --name='<TERM_NAME>'
```

### External Data

### User Roles

The default administrator role has access to all settings.

#### Syllabus Administrator
- Can view/edit all courses
- Can view/edit all documents
- Can view/edit all instructors, departments, semesters, and program levels 
- Can import or update courses from source

#### Syllabus Department Admin
- Can view/edit courses based on department
- Can view/edit PDF documents based on department

### Documents

Only supports PDF documents.

### Reports/Notifications

Changelog
---------



