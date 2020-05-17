import React, { useState } from "react";
import { Form, Input, Tooltip, Checkbox, Button } from "antd";
import { QuestionCircleOutlined } from "@ant-design/icons";

import { formItemLayout, tailFormItemLayout } from "./formLayouts";
import { useStoreActions } from "../../hooks/store.hook";

const Register = () => {
    const [form] = Form.useForm();

    const register = useStoreActions((actions) => actions.user.register);

    const onFinish = (values) => {
        register(values);
    };

    const [] = useState([]);

    return (
        <Form
            {...formItemLayout}
            form={form}
            name="register"
            onFinish={onFinish}
            initialValues={{
                residence: ["zhejiang", "hangzhou", "xihu"],
                prefix: "86",
            }}
            scrollToFirstError
        >
            <Form.Item
                name="fname"
                label={"First Name"}
                rules={[
                    {
                        required: true,
                        message: "Please input your first name!",
                        whitespace: true,
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="lname"
                label={"Last Name"}
                rules={[
                    {
                        required: true,
                        message: "Please input your first name!",
                        whitespace: true,
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="email"
                label="E-mail"
                rules={[
                    {
                        type: "email",
                        message: "The input is not valid E-mail!",
                    },
                    {
                        required: true,
                        message: "Please input your E-mail!",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="password"
                label="Password"
                rules={[
                    {
                        required: true,
                        message: "Please input your password!",
                    },
                ]}
                hasFeedback
            >
                <Input.Password />
            </Form.Item>

            <Form.Item
                name="confirm"
                label="Confirm Password"
                dependencies={["password"]}
                hasFeedback
                rules={[
                    {
                        required: true,
                        message: "Please confirm your password!",
                    },
                    ({ getFieldValue }) => ({
                        validator(_, value) {
                            if (!value || getFieldValue("password") === value) {
                                return Promise.resolve();
                            }

                            return Promise.reject(
                                "The two passwords that you entered do not match!"
                            );
                        },
                    }),
                ]}
            >
                <Input.Password />
            </Form.Item>

            <Form.Item
                name="username"
                label={
                    <span>
                        Username &nbsp;
                        <Tooltip title="What do you want others to call you?">
                            <QuestionCircleOutlined />
                        </Tooltip>
                    </span>
                }
                rules={[
                    {
                        required: true,
                        message: "Please input your username!",
                        whitespace: true,
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="adresse"
                label={"Adresse"}
                rules={[
                    {
                        required: false,
                        message: "Please input your adresse!",
                        whitespace: true,
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="mobile"
                label={"Mobile"}
                rules={[
                    {
                        required: false,
                        message: "Please input your phone number!",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            {/* <Form.Item
                name="agreement"
                valuePropName="checked"
                rules={[
                    {
                        validator: (_, value) =>
                            value
                                ? Promise.resolve()
                                : Promise.reject("Should accept agreement"),
                    },
                ]}
                {...tailFormItemLayout}
            >
                <Checkbox>
                    I have read the <a href="">agreement</a>
                </Checkbox>
            </Form.Item> */}
            <Form.Item {...tailFormItemLayout}>
                <Button type="primary" htmlType="submit">
                    Register
                </Button>
            </Form.Item>
        </Form>
    );
};

export default Register;