# 📂 AkapCsvProcessor

A lightweight **CSV cleansing and processing tool** written in PHP. This tool **cleans, normalizes, and exports** CSV data with proper formatting, ensuring accurate and structured output.

## 🚀 Features
✔️ Cleans CSV data by removing unnecessary characters  
✔️ Standardizes **names, birthdates, and other fields**  
✔️ Deduplicates records based on predefined logic  
✔️ Converts **month names to numeric format**  
✔️ Ensures valid **date and year formatting**  
✔️ Generates a **clean CSV output** for download  
✔️ Works with **large CSV files** without timeout issues  

---

## 📌 **Installation**
### **1 Clone the repository**

git clone https://github.com/yourusername/AkapCsvProcessor.git
cd AkapCsvProcessor

---

## 📌 **2 Project Structure**
✔️ Create the necessary folders that are not available after cloning the git repository

AkapCsvProcessor/

    │── data/            # Folder for input CSV files
    │── output/          # Folder for output CSV files
    │── src/             # Core PHP classes
    │── index.php        # Main entry point for file upload & processing
    │── README.md        # Project documentation
    │── composer.json    # Declaration of autoloading

---

## 📥 Usage

### **1️⃣ Upload a CSV File**
- Access the application via **`http://application_url/`**  
- Upload the **CSV file** containing data in the following format:

| FIRST NAME | MIDDLE NAME | LAST NAME | EXTENSION NAME | BIRTHDATE (MM/DD/YYYY) | SEX | PROVINCE |
|------------|-------------|-----------|----------------|------------------------|-----|----------|
| John       | A.          | Doe       | Jr.            | 01/15/1990             | M   | CAGAYAN    |

---

### **2️⃣ Processing Steps**
✔ **Removes blank rows**  
✔ **Fixes name formatting** (removes special characters, trims spaces)  
✔ **Standardizes birthdate format (MM/DD/YYYY)**  
✔ **Extracts birth year, month, and day**

---

### **3️⃣ Download the Processed CSV**
- The cleaned CSV will be automatically downloaded after processing.  
- The output format follows:

| Firstname | Middlename | Lastname | Extensionname | Birth Date | Birth Year | Birth Month | Birth Day | Sex | Province |
|-----------|------------|----------|---------------|------------|------------|-------------|-----------|-----|----------|
| JOHN      | A          | DOE      | JR            | 01/15/1990 | 1990       | 01          | 15        | M   | CAGAYAN  |

---

## 🤝 Contributing
Feel free to **fork this repo** and submit **pull requests**. Open an issue if you encounter any bugs! 🚀