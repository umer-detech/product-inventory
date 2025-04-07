import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";

function AddProduct() {
    const [name, setName] = useState("");
    const [description, setDescription] = useState("");
    const [price, setPrice] = useState("");
    const navigate = useNavigate();

    const handleSubmit = (e) => {
        e.preventDefault();
        axios.post("/api/products", { name, description, price }, {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        })
        .then(() => navigate("/"));
    };

    return (
        <div className="container">
            <div className="row">
                <div className="col-lg-12">
                    <h1>Welcome to add product page</h1>
                    <div className="card mb-4">
                        <div className="card-header">
                            Add Product
                            <Link className="btn btn-sm btn-info mx-2" to="/">Back</Link>
                        </div>
                        <div className="card-body">
                            <form onSubmit={handleSubmit}>
                                <input type="text" value={name} onChange={e => setName(e.target.value)} placeholder="Name" required />
                                <input type="text" value={description} onChange={e => setDescription(e.target.value)} placeholder="Description" required />
                                <input type="number" value={price} onChange={e => setPrice(e.target.value)} placeholder="Price" required />
                                <button type="submit">Add Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default AddProduct;
