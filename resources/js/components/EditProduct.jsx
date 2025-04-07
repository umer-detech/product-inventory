import React, { useEffect, useState } from "react";
import { Link, useNavigate, useParams } from "react-router-dom";
import axios from "axios";

function EditProduct() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [name, setName] = useState("");
    const [description, setDescription] = useState("");
    const [price, setPrice] = useState("");

    useEffect(() => {
        axios.get(`/api/products/${id}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        })
        .then(response => {
            setName(response.data.data.name);
            setDescription(response.data.data.description);
            setPrice(response.data.data.price);
        });
    }, [id]);

    const handleSubmit = (e) => {
        e.preventDefault();
        axios.put(`/api/products/${id}`, { name, description, price }, {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        })
        .then(() => navigate("/"));
    };

    return (
        <div className="container">
            <div className="row">
                <div className="col-lg-12">
                    <h1>Welcome to edit product page</h1>
                    <div className="card mb-4">
                        <div className="card-header">
                            Edit Product
                            <Link className="btn btn-sm btn-info mx-2" to="/">Back</Link>
                        </div>
                        <div className="card-body">
                            <form onSubmit={handleSubmit}>
                                <input type="text" value={name} onChange={e => setName(e.target.value)} required />
                                <input type="text" value={description} onChange={e => setDescription(e.target.value)} required />
                                <input type="number" value={price} onChange={e => setPrice(e.target.value)} required />
                                <button type="submit">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default EditProduct;
