import React, { useState, useEffect } from "react";
import './bookmarks.css'
import deleteb from './delete.js'
import update from './update';
import './update.css'

function Bookmark() {
  const [bookmarks, setBookmarks] = useState([]);
  const [error, setError] = useState(null);
  const [newBookmark, setNewBookmark] = useState({ title: "", link: "" });
  const [editingId, setEditingId] = useState(null);
  const [editData, setEditData] = useState({ title: "", link: "" });


  useEffect(() => {
    fetchBookmarks();
  }, []);

  const fetchBookmarks = () => {
    fetch("http://localhost:5000/api/readAll.php")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Failed to fetch bookmarks.");
        }
        return response.json();
      })
      .then((data) => setBookmarks(data))
      .catch((err) => setError(err.message));
  };

  const addBookmark = () => {
    if (!newBookmark.title || !newBookmark.link) {
      setError("Both title and link are required.");
      return;
    }

    fetch("http://localhost:5000/api/create.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(newBookmark),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Error: ${response.status}`);
        }
        return response.json();
      })
      .then(() => {
        fetchBookmarks();
        setNewBookmark({ title: "", link: "" });
      })
      .catch((err) => setError(err.message));
  };

  const handleDelete = (id) => {
    deleteb(id)
      .then((result) => {
        if (result) {
          fetchBookmarks();
        } else {
          setError("Failed to delete bookmark. Please try again.");
        }
      })
      .catch((err) => {
        setError(`Error: ${err.message}`);
      });
  };

  const handleModifyClick = (bookmark) => {
    setEditingId(bookmark.id);
    setEditData({ title: bookmark.title, link: bookmark.link });
  };


  const handleUpdate = (id) => {
    const updatedFields = { id }; // Always include the ID

    const original = bookmarks.find((b) => b.id === id);
    if (editData.title !== original.title) updatedFields.title = editData.title;
    if (editData.link !== original.link) updatedFields.link = editData.link;

    update(updatedFields.id, updatedFields.title, updatedFields.link)
      .then((success) => {
        if (success) {
          setEditingId(null); // Exit edit mode
          fetchBookmarks(); // Refresh the list
        } else {
          setError("Failed to update bookmark. Please try again.");
        }
      })
      .catch((err) => {
        setError(`Error: ${err.message}`);
      });
  };



  return (
    <div>
      <h1 id="bookmark-heading">Bookmarks</h1>
      {error && <p id="error-message">{error}</p>}
      <ul id="bookmark-list">
        {bookmarks.map((bookmark) => (
          <li
            key={bookmark.id}
            className={`bookmark-item ${editingId === bookmark.id ? "editing" : ""}`}
          >
            {editingId === bookmark.id ? (
              <div style={{ flex: 1 }}>
                <input
                  type="text"
                  value={editData.title}
                  onChange={(e) =>
                    setEditData({ ...editData, title: e.target.value })
                  }
                  className="bookmark-input"
                />
                <input
                  type="url"
                  value={editData.link}
                  onChange={(e) =>
                    setEditData({ ...editData, link: e.target.value })
                  }
                  className="bookmark-input"
                />
                <button
                  className="bookmark-button update"
                  onClick={() => handleUpdate(bookmark.id)}
                >
                  Update
                </button>
              </div>
            ) : (
              <>
                <span className="bookmark-title">{bookmark.title}</span>
                <a
                  href={bookmark.link}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="bookmark-link"
                >
                  {bookmark.link}
                </a>
              </>
            )}

            {editingId !== bookmark.id && (
              <button
                className="bookmark-modify"
                onClick={() => handleModifyClick(bookmark)}
              >
                Modify
              </button>
            )}

            <div
              className="bookmark-icon"
              onClick={() => handleDelete(bookmark.id)}
            >
              X
            </div>
          </li>
        ))}

        <li className="bookmark-add">
          <input
            type="text"
            placeholder="Title"
            value={newBookmark.title}
            onChange={(e) =>
              setNewBookmark({ ...newBookmark, title: e.target.value })
            }
            className="bookmark-input"
          />
          <input
            type="url"
            placeholder="Link"
            value={newBookmark.link}
            onChange={(e) =>
              setNewBookmark({ ...newBookmark, link: e.target.value })
            }
            className="bookmark-input"
          />
          <button onClick={addBookmark} className="bookmark-button">
            Add
          </button>
        </li>
      </ul>
      <p>Logout</p>
    </div>
  );
}

export default Bookmark;  