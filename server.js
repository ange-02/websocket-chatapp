//type npm run start in the console to start server

var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);
var express = require('express')
    // ^^ importing libraries ^^

//setting public folder as a static folder, which the server can use
app.use(express.static('public'));
var conns = [];
var users = [];

// when a user connects, execute this

function roomUsers(room, conns) {
    var users_in_room = []
    for (i = 0; i < conns.length; i++) {
        if (conns[i]['room'] == room) {
            users_in_room.push([conns[i]['username'], conns[i]['pfp'], conns[i]['color']])
        }
    }
    return users_in_room
}

io.on('connection', (socket) => {
    //upon receiving a 'chat message' function from the client side, send the message to the rest
    // of the server
    socket.on('username receive', (username, pfp, room, color) => {
        console.log(room)
        socket.join(room)
        if (!(users.includes(username))) {
            conns.push({
                'username': username,
                'socketid': socket.id,
                'room': room,
                'pfp': pfp,
                'color': color
            });
            users.push(username)
            io.to(room).emit('new conn', roomUsers(room, conns));
            console.log(conns)
        }

        socket.on('chat message', (msg, username, pfp, color) => {
            //broadcast to everyone but user
            socket.broadcast.to(room).emit('chat message', msg, username, pfp, color);
            //broadcast to user only
            socket.emit('my message', msg, username, pfp, color);
        });

        socket.on('disconnect', () => {
            for (i = 0; i < conns.length; i++) {
                //console.log(conns[i])
                if (conns[i]['socketid'] === socket.id) {
                    console.log(`${socket.id} disconnected`);
                    console.log(users)
                    if (i == 0) {
                        conns.shift()
                        users.shift()
                    } else {
                        conns.pop(i)
                        users.pop(i)
                        console.log(conns)
                    }
                }
            }
            io.to(room).emit('new conn', roomUsers(room, conns))
        });
    })


})

// telling the server to run off port 3000
var PORT = process.env.PORT || 3000
http.listen(PORT, () => {
    console.log(`listening on *:${PORT}`);
});