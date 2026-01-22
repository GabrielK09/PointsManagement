interface UserContract
{
    readonly id: string;
    name: string;
    email: string;
    password: string;
    team: ''|'Cinza'|'Azul'|'Verde'|'Vermelho'|'Roxo'|'Marrom'|'Laranja'|'Amarelo';

    pulled: number;
    called: number;
    whatsApp: number;
    indicate: number;
    xremote: number;
    chat: number;
};
