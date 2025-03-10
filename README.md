# :page_facing_up: AKAP Parser

A lightweight **CSV cleansing and processing tool** written in PHP. This tool **cleans, normalizes, and exports** CSV data with proper formatting needed in processing the AKAP data.

## :rocket: Features
:heavy_check_mark: Cleans CSV data by removing unnecessary characters  
:heavy_check_mark: Standardizes **names, birthdates, and other fields** 
:heavy_check_mark: Generates a **clean CSV output** for download  
:heavy_check_mark: Works with **large CSV files** seamlessly  

---

## :pushpin: **Installation**
### **1 Clone the repository and install composer**
```    
git clone https://github.com/jmmaguigad/AKAP-Parser.git
```
```
cd AKAP-Parser
```
```
composer install
```
---

## :pushpin: **2 Project Structure**
:heavy_check_mark: Create the necessary folders that are not available after cloning the git repository

AKAP-Parser/
    │── data/            # Folder for input CSV files
    │── output/          # Folder for output CSV files
    │── src/             # Core PHP classes
    │── index.php        # Main entry point for file upload & processing
    │── README.md        # Project documentation
    │── composer.json    # Declaration of autoloading

---

## :pushpin: Usage

### **:one: Upload a CSV File**
- Access the application via **`http://application_url/`**  
- Upload the **CSV file** containing data in the following format:

| FIRST NAME | MIDDLE NAME | LAST NAME | EXTENSION NAME | BIRTHDATE (MM/DD/YYYY) | SEX | PROVINCE |
|------------|-------------|-----------|----------------|------------------------|-----|----------|
| John       | A.          | Doe       | Jr.            | 01/15/1990             | M   | CAGAYAN  |

---

### **:two: Processing Steps**
:heavy_check_mark: **Removes blank rows**  
:heavy_check_mark: **Fixes name formatting** (removes special characters, trims spaces)  
:heavy_check_mark: **Standardizes birthdate format (MM/DD/YYYY)**  
:heavy_check_mark: **Extracts birth year, month, and day**

---

### **:three: Download the Processed CSV**
- The cleaned CSV will be automatically downloaded after processing.  
- The output format follows:

| firstname | middlename | lastname | extensionname | birth_date | birth_year | birth_month | birth_day | sex | province |
|-----------|------------|----------|---------------|------------|------------|-------------|-----------|-----|----------|
| JOHN      | A          | DOE      | JR            | 01/15/1990 | 1990       | 01          | 15        | M   | CAGAYAN  |

---

## :pushpin: Contributing
Feel free to **fork this repo** and submit **pull requests**. Open an issue if you encounter any bugs! 🚀