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

### Recommended Plugins

- Advanced Custom Fields - visual interface for custom fields

### Supported Plugins


Documentation
--------------

Departments (syllabus_department)

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

Changelog
---------



