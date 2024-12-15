import { useState, useEffect } from 'react';
import './Login.css'
import { useNavigate } from "react-router-dom";


function Login() {
    const navigate = useNavigate(); // Initialize navigate here

    const [user, setUser] = useState("");
    const [pass, setPass] = useState("");
    const [error, setError] = useState("");
    const [msg, setMsg] = useState("");
    const [userId, setUserId] = useState(null);


    const handleInput = (e, type) => {
        setError("");
        switch (type) {
            case 'user':
                setUser(e.target.value.trim());
                break;
            case 'pass':
                setPass(e.target.value.trim());
                break;
            default:
        }
    }



    
    const handleSubmit = (e) => {
        e.preventDefault();
        if (user.trim() === "") {
            setError("Please Enter Username");
            return;
        }
        if (pass.trim() === "") {
            setError("Please Enter Password");
            return;
        }
        if (user.trim() !== "" && pass != "") {
            var url = "http://localhost:5000/api/login.php"
            var headers = {
                "Accept": "application/json",
                "Content-type": "application/json"
            };
            var Data = {
                username: user,
                password: pass
            };
            fetch(url, {
                method: "POST",
                headers: headers,
                body: JSON.stringify(Data)
            }).then((response) => {
                if (!response.ok) {
                    throw new Error("Invalid username or password");
                }
                return response.json();
            })
                .then((response) => {
                    if (response.user_id) {
                        setUserId(response.user_id);
                        setMsg(response.message);
                        navigate("/bookmarks"); // Navigate to the bookmarks page

                    } else {
                        throw new Error("Login failed");
                    }
                })
                .catch((err) => {
                    setError(err.message);
                });
        };
    }
        useEffect(() => {
            setTimeout(function () {
                setMsg("");
            }, 5000);
        }, [msg]);

        return (
            <div className="login form">
                <p>
                    {
                        error != "" ?
                            <span className='error'>{error}</span> :
                            <span className='success'>{msg}</span>
                    }
                </p>
                <form onSubmit={handleSubmit}>
                    <label>Username</label>
                    <input type="text" value={user} onChange={(e) => handleInput(e, "user")} />
                    <label>Password</label>
                    <input type="password" value={pass} onChange={(e) => handleInput(e, "pass")} />
                    <input type="submit"
                        value="Login"
                        className="button"
                    />
                </form>
            </div>
        );
    }
    export default Login;