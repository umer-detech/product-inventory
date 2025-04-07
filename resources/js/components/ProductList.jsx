import React, { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";

function ProductList() {
    const [products, setProducts] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        axios.get("/api/products", {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        })
        .then(response => setProducts(response.data.data))
        .catch(() => navigate("/login"));
    }, []);

    const handleDelete = (id) => {
        axios.delete(`/api/products/${id}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
        })
        .then(() => setProducts(products.filter(product => product.id !== id)));
    };
    const baseUrl = 'http://127.0.0.1:8000/storage/';

    return (
        <div className="container">
            <div className="row">
                <div className="col-lg-12">
                    <button onClick={() => { localStorage.removeItem("token"); navigate("/login"); }}>Logout</button>
                    <h1>Welcome to users page</h1>
                    <div className="card mb-4">
                        <div className="card-header">
                            Product Details
                            <Link className="btn btn-sm btn-info mx-2" to="/add">Add Product</Link>
                        </div>
                        <div className="card-body">
                            <div className="table-responsive">
                                <table className="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            {/* <th>Image</th> */}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {
                                            products.length > 0 ?

                                            products.map((item) => {
                                                return <tr key={item.phone}>
                                                    <th scope="row">1</th>
                                                    <td>{item.name}</td>
                                                    <td>{item.description}</td>
                                                    <td>{item.price}</td>
                                                    {/* <td><img style={{ width: '60px' }} src={baseUrl+item.image} alt='' /></td> */}
                                                    <td>
                                                        <Link className='btn btn-sm btn-info mx-2' to={`/edit/${item.id}`}>Edit</Link>
                                                        <button className='btn btn-sm btn-danger mx-2' onClick={() => handleDelete(item.id)}>Delete</button>
                                                    </td>
                                                </tr>
                                            }) :
                                            <tr className='text-center'>
                                                <td colSpan={6}>No Products found</td>
                                            </tr>

                                        }
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default ProductList;
