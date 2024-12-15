async function update(id, title, link) {
    try {
      const payload = { id };
      if (title) payload.title = title;
      if (link) payload.link = link;
      console.log("Payload being sent:", { id, title, link });

      const response = await fetch("http://localhost:5000/api/update.php", {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(payload),
      });
  
      if (!response.ok) {
        throw new Error(`Error: ${response.status}`);
      }
      const data = await response.json();
      console.log("Updated bookmark:", data);
      return true;
    } catch (err) {
      console.error("Failed to update bookmark:", err.message);
      return false;
    }
  }
  
  export default update;  