import React from 'react';
import axios from 'axios';

const PLAYER1 = 'X';
const PLAYER2 = 'O';
const EMPTY_CELL = '_';

class Square extends React.Component {
    constructor(props) {
        super(props);
        this.state = {'isHovered': false}
        this.onHover = this.onHover.bind(this);
    }

    onHover(e) {
        this.setState({'isHovered': (e.type == "mouseenter")});
    }

    render() {
        let map = {}
        map[PLAYER1] = "fa fa-close";
        map[PLAYER2] = "fa fa-circle-o";
        map[EMPTY_CELL] = "fa";

        let props = this.props;
        let playerIconClassName, playerClassName = "";

        playerIconClassName = map[props.player];

        if (props.player == PLAYER1) {
            playerClassName = 'player-x';
        } else if (props.player == PLAYER2) {
            playerClassName = 'player-o';
        } else {
            if (this.state.isHovered) {
                playerIconClassName = map[props.game.currentPlayer];
            } else {
                playerIconClassName = "fa";
            }
        }
        return (
            <button className={"square " + playerClassName}
                onClick={() => props.onClick()}
                onMouseEnter={this.onHover}
                onMouseLeave={this.onHover}
                >
                <i className={playerIconClassName}></i>
            </button>
        );
    }
}

class Board extends React.Component {
    constructor(props)
    {
        super(props);
    }

    renderSquare(i, player=null) {
        var className;

        if (player === null) {
            player = this.props.cells[i];
        }

        switch (player) {
            case PLAYER1:
                className = 'fa fa-close';
                break;
            case PLAYER2:
                className = 'fa fa-circle-o';
                break;
            default:
                className = 'fa';
                break;
        }

        if (this.props.cells[i] == 'X') {
            className = 'fa fa-close';
        } else if (this.props.cells[i] == 'O') {
            className = 'fa fa-circle-o';
        } else {
            className = "fa";
        }

        return (
            <Square className={className}
                player={this.props.cells[i]}
                game={this.props.game}
                onClick={() => this.props.onClick(i)}
                onMouseEnter={(i) => this.handleHover(i)} />
        );
    }

    render() {
        return (
            <div>
                <div className="board-row">
                    {this.renderSquare(0)}
                    {this.renderSquare(1)}
                    {this.renderSquare(2)}
                </div>
                <div className="board-row">
                    {this.renderSquare(3)}
                    {this.renderSquare(4)}
                    {this.renderSquare(5)}
                </div>
                <div className="board-row">
                    {this.renderSquare(6)}
                    {this.renderSquare(7)}
                    {this.renderSquare(8)}
                </div>
            </div>
        );
    }
}

class Game extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            "currentPlayer": PLAYER1, // X goes first
            "cells": Array(9).fill(EMPTY_CELL),
            "xIsNext": true
        };
    }

    makeMove() {
        const cells = this.state.cells;

        let payload = {
            "jsonrpc": "2.0",
            "id": "whatever",
            "method": "makeMove",
            "params": {
                "boardState": [
                    cells.slice(0, 3),
                    cells.slice(3, 6),
                    cells.slice(6, 9)
                ],
                "player": this.state.currentPlayer
            }
        };
        axios.post("/jsonrpc/v1/", payload).then(
            (response) => {
                if (response.data.result && response.data.result.length == 3) {
                    this.move(response.data.result[0], response.data.result[1]);
                }
        });
    }

    move(x, y) {
        const cells = this.state.cells.slice();
        cells[x * 3 + y] = this.state.currentPlayer;

        this.setState({
            cells: cells,
            currentPlayer: this.state.currentPlayer == PLAYER1 ? PLAYER2 : PLAYER1
        });
    }

    handleClick(i) {
        if (this.state.cells[i] !== EMPTY_CELL) {
            return;
        }
        let cells = this.state.cells.slice();
        cells[i] = this.state.currentPlayer;
        this.setState({
            cells: cells,
            currentPlayer: this.state.currentPlayer == PLAYER1 ? PLAYER2 : PLAYER1
        });
    }

    render() {
        let playerClassName = (this.state.currentPlayer == PLAYER1 ? "player-x": "player-o");

        let status = "Next player: " + (this.state.currentPlayer);
        return (
            <div className={"game row " + playerClassName}>
                <div className="col-md-6">
                    <div className="board">
                        <Board cells={this.state.cells} game={this.state} onClick={(i) => this.handleClick(i)}/>
                    </div>
                </div>
                <div className="game-info col-md-6">
                    <div className="status">{status}</div>
                    <button onClick={() => this.makeMove()}>Bot move</button>
                </div>
            </div>
        );
    }
}

export default Game;
