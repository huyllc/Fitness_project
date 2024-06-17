import axios from "axios";

export async function verifyToken(token) {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/admin/verify_token', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        return response.data;
    } catch (error) {
        console.error(error.response.data.error);
    }
}