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
- Advanced Custom Fields - visual interface for custom fields

### Supported Plugins


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

- __Course Administrator__ - Can view/edit all courses and change settings for any department.
- __Department Administrator__ - User role that gives access only to the user's department.

### Documents

### Reports/Notifications

Changelog
---------



