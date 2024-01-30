<!-- src/views/UploadPage.vue -->

<template>
  <div class="upload-container">
    <h2>Upload Page</h2>
    <router-link to="/list">
      <button class="back-button">Back to List</button>
    </router-link>
    <div class="file-drop-container" @dragover.prevent @drop="handleDrop" @click="handleClick">
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
    handleClick(event) {
      if (event.target.tagName !== 'INPUT') {
        this.$refs.fileInput.click();
      }
    },
    uploadFile() {
      if (!this.selectedFile) {
        alert('Please select a CSV file.');
        return;
      }

      const formData = new FormData();
      formData.append('file', this.selectedFile);

      axios.post(`${import.meta.env.VITE_API_URL}/index.php/upload`, formData)
        .then(response => {
          console.log(response.data);
          this.$router.push('/list');
        })
        .catch(error => {
          console.error(error);
          alert('Error uploading file. Please try again.');
        });
    }
  }
};
</script>

<style scoped>
h2 {
  font-size: 1.5em;
  margin-bottom: 20px;
}

.back-button {
  background-color: #4caf50;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin: auto auto 20px auto;
}

.upload-container {
  margin: auto;
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
