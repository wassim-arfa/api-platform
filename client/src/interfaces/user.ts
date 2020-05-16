export interface User {
  '@id'?: string;
  readonly username: string;
  readonly roles?: any;
  readonly password: string;
  readonly salt?: any;
  readonly createdAt?: Date;
  readonly updatedAt?: Date;
  readonly passwordChangeDate?: number;
  readonly newPassword?: any;
  readonly newRetypedPassword?: any;
  readonly oldPassword?: any;
  readonly fname: string;
  readonly lname: string;
  readonly email: string;
  readonly address?: string;
  readonly bio?: string;
  readonly mobile?: string;
  readonly landline?: string;
  readonly enabled?: boolean;
  readonly confirmationToken?: string;
  id?: string;
}
