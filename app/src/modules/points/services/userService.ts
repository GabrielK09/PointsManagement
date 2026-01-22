import { api } from "src/boot/axios";
import { returnResApi } from "src/helpers/return/handleApi";

export async function getAllUsersService(): Promise<any>
{
    try {
        const res = await api.get('/user/get-all-for-team');

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
