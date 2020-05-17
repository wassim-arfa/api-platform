import { User } from "./user";

export interface UserRegister extends User {
    readonly password?: any;
    readonly confirmPassword?: any;
}
