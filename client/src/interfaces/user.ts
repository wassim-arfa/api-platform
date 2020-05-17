export interface User {
    "@id"?: string;
    readonly address?: string;
    readonly bio?: string;
    readonly createdAt?: Date;
    readonly email: string;
    readonly fname: string;
    readonly landline?: string;
    readonly lname: string;
    readonly mobile?: string;
    readonly passwordChangeDate?: number;
    readonly updatedAt?: Date;
    readonly username: string;
    id?: string;
}
