# xmltodb

This is a command line application, based on Laravel Zero, that processes XML data and stores it in a Database Management System (DBMS). 
While the current implementation is configured to use MySQL, the application is architected to easily accommodate other DBMSs with minimal configuration changes.

## Prerequisites

Ensure you have the following installed on your system:

- Docker
- Docker Compose

## Getting Started

1. Clone the repository to your local system.
2. Navigate to the project folder.


## Configuration for MySQL (Default)

The application is pre-configured for MySQL. 
You need to adjust the path for your xml file in docker-compose.yml. Currently (feed.xml) which was provided with the task has been added in the project folder.
If you want to use the default feed.xml which is inside the project folder then you don't need to do any change related to xml file.
Follow these steps to build and run the Docker container:

1. Run the following command:

``
docker-compose up -d
``

2. After the image is created and the container is up, go to the Docker app and open a terminal in the 'app' service of the running container.
3. Run the following command to ensure everything is set up correctly:

``
php xmltodb
``

4. Run the migrations command to setup the database:

``
php xmltodb migrate
``

5. To process an XML file to the database, run the following command (replace "feed.xml" with your actual XML file name). 

``
php xmltodb app:all feed.xml
``

6.To run the tests, use the following command:

``
php xmltodb test
``

## Configuration 
If you want to use a different DBMS, you need to modify the Dockerfile, docker-compose.yml file and the .env file to include the required PHP extensions and server configurations. 
Here is an overview of what you need to do:

1. Dockerfile: Add the necessary PHP extensions based on the DBMS.
2. docker-compose.yml: Update the DB service according to your DBMS.
3. .env: Update the database configuration parameters to match your DBMS.


After making the changes, repeat the steps under "Configuration for MySQL" to build and run the application.

## Logging

The application has built-in logging mechanisms for error tracking. Errors during the execution of the application are logged into a file for debugging and record-keeping purposes.

The log file can be found at `logs/xml_rocessor.log` in the application directory.

This provides a convenient way to track down any issues or unexpected behaviour during the XML data processing, making troubleshooting easier.


## Limitations and Future Improvements
1. The current test cases do not cover all possible scenarios. More test cases should be added in the future for more comprehensive testing.
2. The application currently only supports DBMS. In future it can implemented for file storage as well
For any issues or suggestions, feel free to open an issue on the GitHub repository.

