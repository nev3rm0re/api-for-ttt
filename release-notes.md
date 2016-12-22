# Release 1.2.0

Board logic was improved - now Bot will refuse to make a move on a Board in
a win or illegal state. That's why I had to bump minor version - API
expectations changed a bit.

# Release 1.1.0

This release contains eye-candy to the web client. Added hover effects,
transitions and colors. Since my artistic abilities are quite modest, I got
inspiration from [Pure CSS TicTacToe](https://codepen.io/ziga-miklic/pen/Fagmh)
design (and some of the solutions)

# Release 1.0.1

Removed unused dependencies and externalized bigger ones. Now `tictactoe.js`
is 58K compared to 800+K before. Web-client now requires client to have an
internet connection.

Original behaviour is now called "offline" build and can be built using
npm:

```bash
$ yarn run webpack:build:offline
```
This will pack `react` and `react-dom` dependencies into `tictactoe.js` bundle.

# Release 1.0.0
Cleaned up code, make client-side completely client-side.
Verified that API works using PHP's built-in server.
Updated README file.

There's still some work to do:

  - Make sure `tictactoe.js` is not that huge by switching to
    `externals` and `scriptjs`
  - Add proper brains to both Bot and the Board - make it detect game end
    and the winner, disallow clicking on cells after win etc
  - Create REST API version of the bot

# Release 0.2.0

This release adds web client to an API available at http://localhost:8000/client.

Client allows player to make moves and ask for a move from the API.

Next release - code cleanup and documentation.

# Release 0.1.0

This release contains pretty dumb bot wrapped in JSON-RPC API.

Current version of the bot moves to first available cell on a board,
doesn't validate board, and returns an error response when asked to make a
move on a full board.