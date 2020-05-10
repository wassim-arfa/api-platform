export interface User {
  '@id'?: string;
  id?: string;
  username?: string;
  roles?: any;
  password?: string;
  salt?: any;
  createdAt?: Date;
  updatedAt?: Date;
  passwordChangeDate?: number;
  newPassword?: any;
  newRetypedPassword?: any;
  oldPassword?: any;
  fname?: string;
  lname?: string;
  email?: string;
  address?: string;
  bio?: string;
  mobile?: string;
  landline?: string;
  enabled?: boolean;
  confirmationToken?: string;
}
