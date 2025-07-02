document.getElementById("uploadBtn").addEventListener("click", async () => {
  const file = document.getElementById("fileInput").files[0];
  const resultBox = document.getElementById("result");

  if (!file || file.type !== "image/png") {
    resultBox.textContent = "❌ Please select a valid .png skin file.";
    return;
  }

  const formData = new FormData();
  formData.append("skin", file);

  resultBox.textContent = "⏳ Uploading...";

  try {
    const response = await fetch("upload.php", {
      method: "POST",
      body: formData
    });

    const json = await response.json();
    if (json.success) {
      resultBox.innerHTML = `✅ Uploaded!<br><a href="${json.url}" target="_blank">${json.url}</a>`;
    } else {
      resultBox.textContent = "❌ Error: " + json.error;
    }
  } catch (error) {
    console.error(error);
    resultBox.textContent = "❌ Upload failed.";
  }
});
