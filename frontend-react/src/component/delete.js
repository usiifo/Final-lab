function deleteb(id) {
    return fetch("http://localhost:5000/api/delete.php", {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({id}),
    })
      .then((response) => {
        if (!response.ok) {
          return false;
        }
        return response.json();
      })
      .then((data) => {
        return true;
      })
      .catch((err) => {
        console.error("Failed to delete bookmark:", err.message);
        throw err;
      });
  }
  
  export default deleteb;
  