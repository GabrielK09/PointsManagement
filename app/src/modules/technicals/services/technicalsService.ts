import { api } from "src/boot/axios";
import { returnResApi } from "src/helpers/return/handleApi";

export async function createUserService(user: UserContract): Promise<any>
{
    try {
        const res = await api.post('/user/create', user);

        return returnResApi(
            true,
            res.data.message,
            res.data.data,
        );

    } catch (error) {
        return returnResApi(
            false,
            error.response?.data?.message,
            []
        );
    };
};
