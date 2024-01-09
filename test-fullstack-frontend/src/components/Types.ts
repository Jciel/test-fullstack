
export type LoginData = {
    'email': string,
    'password': string
}

export type RegisterData = {
    'name': string,
    'email': string,
    'password': string
}

export type AlertData = {
    title: string,
    message: string,
    type: "error" | "success" | "warning",
    active: Boolean
}
