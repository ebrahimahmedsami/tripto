export default class Gate{
    constructor(user){
        this.user = user;
    }

    hasPermission(cr_role){
        let user = this.user;
        if(user.status){
            if(!user.permissions.length)
                return false;
            for (let permission of user.permissions){
                if((permission.read ? 'read ' : '') + permission.name == cr_role)
                    return true;
                else if((permission.write ? 'write ' : '') + permission.name == cr_role)
                    return true;
                else if((permission.update ? 'update ' : '') + permission.name == cr_role)
                    return true;
                else if((permission.delete ? 'delete ' : '') + permission.name == cr_role)
                    return true;
                else
                    continue;
            }
            return false;
        }
        return false;
    }
}
