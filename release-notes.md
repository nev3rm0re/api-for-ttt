# Release 0.2.0

This release adds web client to an API available at http://localhost:8000/client.

Client allows player to make moves and ask for a move from the API.

Next release - code cleanup and documentation.

# Release 0.1.0

This release contains pretty dumb bot wrapped in JSON-RPC API.

Current version of the bot moves to first available cell on a board,
doesn't validate board, and returns an error response when asked to make a
move on a full board.