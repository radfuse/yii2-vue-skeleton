const USER_KEY = 'user';

const UserService = {
    getUser() {
        let user = localStorage.getItem(USER_KEY);

        if(user)
            return JSON.parse(user);

        return {};
    },
    setUser(user) {
        user = JSON.stringify(user);
        localStorage.setItem(USER_KEY, user);
    },
    removeUser() {
        localStorage.removeItem(USER_KEY);
    },
}

export default UserService;