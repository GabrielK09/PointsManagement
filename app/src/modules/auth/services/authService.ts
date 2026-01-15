import { api } from "src/boot/axios";
import { returnResApi } from "src/helpers/return/handleApi";

export async function loginService(email: string, password: string): Promise<ReturnResApi>
{
    try {
        const res = await api.post('/auth/login', {
            email: email,
            password: password

        });

        return returnResApi(
            true,
            res.data.message,
            res.data.data,
        );

    } catch (error) {
        return returnResApi(
            true,
            error.response?.data?.message,
            []
        );      
    };
};