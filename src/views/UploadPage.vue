<!-- src/views/UploadPage.vue -->

<template>
    <div class="upload-container">
      <h2>Upload Page</h2>
      <div class="file-drop-container" @dragover.prevent @drop="handleDrop">
        <input
          type="file"
          ref="fileInput"
          @change="handleFileChange"
          accept=".csv"
          class="file-input"
        />
        <p v-if="!selectedFile" class="drop-message">Drag & Drop a CSV file here or click to browse</p>
        <p v-if="selectedFile" class="file-name">{{ selectedFile.name }}</p>
      </div>
      <button @click="uploadFile" :disabled="!selectedFile">Upload CSV</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        selectedFile: null
      };
    },
    methods: {
      handleFileChange(event) {
        this.selectedFile = event.target.files[0];
      },
      handleDrop(event) {
        event.preventDefault();
        this.selectedFile = event.dataTransfer.files[0];
      },
      uploadFile() {
        if (!this.selectedFile) {
          alert('Please select a CSV file.');
          return;
        }
  
        const formData = new FormData();
        formData.append('file', this.selectedFile);
  
        axios.post('http://localhost:8080/upload.php', formData)
          .then(response => {
            // Handle success
            console.log(response.data);
            alert('File uploaded successfully!');
            this.selectedFile = null; // Clear the selected file after successful upload
          })
          .catch(error => {
            // Handle error
            console.error(error);
            alert('Error uploading file. Please try again.');
          });
      }
    }
  };
  </script>
  
  <style scoped>
  .upload-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    text-align: center;
  }
  
  .file-drop-container {
    border: 2px dashed #ccc;
    padding: 20px;
    cursor: pointer;
    position: relative;
  }
  
  .file-input {
    display: none;
  }
  
  .drop-message {
    color: #777;
  }
  
  .file-name {
    margin: 10px 0;
    font-weight: bold;
    color: #333;
  }
  
  button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
  }
  </style>
  