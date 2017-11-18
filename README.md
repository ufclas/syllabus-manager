UFCLAS Syllabus Manager
=======================

(In development) Manages custom post types, taxonomies, and metadata for the CLAS Syllabus website.

Installation
-------------

Download and unzip files into a folder named 'ufclas-syllabus-manager' in the plugins directory. Activate plugin in your site.

### Required
- [LH User Taxonomies](https://wordpress.org/plugins/lh-user-taxonomies/) - allows setting departments for users

### Recommended
- [Admin Columns Pro](https://www.admincolumns.com/) - Custom admin columns. Pro license allows advanced media filtering and inline editing
- [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/) - visual interface for custom fields
- [GM Media Tags](https://github.com/gmazzap/GMMediaTags) - adds ability to bulk add taxonomies for multiple documents

Documentation
--------------

- [Getting Started](#getting-started)
- [Importing Course Data from an External Source](#importing-course-data)
- [Managing User Roles](#managing-user-roles)
- [Managing Courses](#managing-courses)
    - [Departments](#departments)
    - [Semesters](#semesters)
	- [Program Levels](#program-levels)
    - [Instructors](#instructors)
- [Managing Syllabus Documents](#managing-syllabus-documents)
- [Managing Reports](#managing-reports)

### Getting Started

### Importing Course Data

### Managing User Roles

The default administrator role is granted access to all courses and settings on plugin activation.

__Syllabus Administrator__ Role that can manage all courses and media, not WordPress settings, plugins, or themes. Based on the administrator role. 
- Can view/edit all courses
- Can view/edit all documents
- Can view/edit all instructors, departments, semesters, and program levels 
- Can import or update courses from source

__Syllabus Department Admin__ Role that can manage courses and media only for a department. Based on the editor role. 
- Can view/edit courses based on department
- Can view/edit PDF documents based on department


#### Setting User Role and Department

Users with the Syllabus Department Admin role must have a department set before they can view any courses or media. 

- Edit the user's profile by going to __Users__ in the dashboard menu.
- Change the __Role__ to __Syllabus Department Admin__. 
- In the __Select Department__ section, place a check next to the department name. 

The list of departments comes from the Departments taxonomy. To test that access has been granted correctly, you can use a plugin like [User Switching](https://wordpress.org/plugins/user-switching/).


### Managing Courses

Syllabus Manager adds the __Courses__ and __Syllabus Manager__ menu items to the dashboard menu.

Post Type:

- __Courses__ (syllabus_course)

Taxonomies:

- __Departments__: Used to categorize Courses (syllabus_department)
- __Semesters__ (syllabus_semester)
- __Instructors__ (syllabus_instructor)
- __Program Level__ (syllabus_level)


### Departments

The Department is a custom taxonomy that can be assigned to Courses or Media post types. Departments can have sub-departments.

Taxonomy (``syllabus_department``):
- __Name__ - Title displayed in department list page.
- __Slug__ - Appears in department detail page URL.
- __Description__ - Appears in department detail page.

Term Meta:
- __Department Code__: Optional internal code for department (``sm_department_id``)
- __Website__:  URL to department website (``sm_department_website``)
- __Cover Image__:  ID of uploaded image for department detail page. (``sm_department_cover``)

### Semesters

### Program Levels

### Instructors

### Managing Syllabus Documents

### Managing Reports

Changelog
---------



