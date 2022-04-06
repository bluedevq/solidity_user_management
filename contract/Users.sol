// SPDX-License-Identifier: GPL-3.0
pragma solidity >=0.8.7;
pragma experimental ABIEncoderV2;

contract Users {
    struct User {
        uint id;
        string name;
        string gender;
    }

    User[] private users;

    uint private nextId;

    function list() public view returns(User[] memory) {
        return users;
    }

    function create(string memory name, string memory gender) public {
        users.push(User(nextId, name, gender));
        ++nextId;
    }

    function update(uint id, string memory name, string memory gender) public {
        User storage user = findById(id);
        user.name = name;
        user.gender = gender;
    }

    function remove(uint id) public {
        for(uint i = 0; i < users.length; i++) {
            if(users[i].id == id) {
                delete users[i];
            }
        }
    }

    function findUser(uint id) public view returns(User memory) {
        User storage user = findById(id);
        return user;
    }

    function findById(uint id) private view returns(User storage)  {
        for(uint i = 0; i < users.length; i++) {
            if(users[i].id == id) {
                return users[i];
            }
        }
        revert("User does not exits");
    }
}
