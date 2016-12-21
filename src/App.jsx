import React from 'react';
import {render} from 'react-dom';

const PLAYER1 = 'X';
const PLAYER2 = 'O';
const EMPTY_CELL = '_';

function Square(props) {
    let playerClassName;

    if (props.player == PLAYER1) {
        playerClassName = "fa fa-close";
    } else if (props.player == PLAYER2) {
        playerClassName = "fa fa-circle-o";
    } else {
        playerClassName = "fa";
    }
    return (
        <button className="square" onClick={() => props.onClick()}>
            <i className={playerClassName}></i>
        </button>
    );
}

class Board extends React.Component {
    constructor(props)
    {
        super(props);
    }
    renderSquare(i) {
        var className;
        if (this.props.cells[i] == 'X') {
            className = 'fa fa-close';
        } else if (this.props.cells[i] == 'O') {
            className = 'fa fa-circle-o';
        } else {
            className = 'fa ';
        }

        return (
            <Square className={className}
                player={this.props.cells[i]}
                onClick={() => this.props.onClick(i)} />
        );
    }

    render() {
        let status;
        status = "Next player: " + (this.props.game.currentPlayer);
        return (
            <div>
                <div className="status">{status}</div>
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
        return (
            <div className="game row">
                <div className=" col-md-6">
                    <div className="board">
                        <Board cells={this.state.cells} game={this.state} onClick={(i) => this.handleClick(i)}/>
                    </div>
                </div>
                <div className="game-info col-md-6">
                    <div>{/* status */}</div>
                    <div>{/* TODO */}</div>
                </div>
            </div>
        );
    }
}

export default Game;
