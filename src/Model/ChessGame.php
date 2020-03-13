<?php


namespace App\Model;


use App\Interfaces\ChessPieceInterface;
use App\Service\ChessPieceGenerator;


class ChessGame
{
    const BLACK = 'b';
    const WHITE = 'w';

    const PAWN = 'p';
    const KNIGHT = 'n';
    const BISHOP = 'b';
    const ROOK = 'r';
    const QUEEN = 'q';
    const KING = 'k';

    const PIECES_NAMES = [
        'p' => 'Pawn',
        'n' => 'Knight',
        'b' => 'Bishop',
        'r' => 'Rook',
        'q' => 'Queen',
        'k' => 'King',
    ];

    const ALLOWED_SYMBOLS = 'pnbrqkPNBRQK';

    const DEFAULT_POSITION = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

    const ATTACKS = [
        20, 0, 0, 0, 0, 0, 0, 24, 0, 0, 0, 0, 0, 0, 20, 0,
        0, 20, 0, 0, 0, 0, 0, 24, 0, 0, 0, 0, 0, 20, 0, 0,
        0, 0, 20, 0, 0, 0, 0, 24, 0, 0, 0, 0, 20, 0, 0, 0,
        0, 0, 0, 20, 0, 0, 0, 24, 0, 0, 0, 20, 0, 0, 0, 0,
        0, 0, 0, 0, 20, 0, 0, 24, 0, 0, 20, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, 20, 2, 24, 2, 20, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, 2, 53, 56, 53, 2, 0, 0, 0, 0, 0, 0,
        24, 24, 24, 24, 24, 24, 56, 0, 56, 24, 24, 24, 24, 24, 24, 0,
        0, 0, 0, 0, 0, 2, 53, 56, 53, 2, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, 20, 2, 24, 2, 20, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 20, 0, 0, 24, 0, 0, 20, 0, 0, 0, 0, 0,
        0, 0, 0, 20, 0, 0, 0, 24, 0, 0, 0, 20, 0, 0, 0, 0,
        0, 0, 20, 0, 0, 0, 0, 24, 0, 0, 0, 0, 20, 0, 0, 0,
        0, 20, 0, 0, 0, 0, 0, 24, 0, 0, 0, 0, 0, 20, 0, 0,
        20, 0, 0, 0, 0, 0, 0, 24, 0, 0, 0, 0, 0, 0, 20
    ];

    const RAYS = [
        17, 0, 0, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 15, 0,
        0, 17, 0, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 15, 0, 0,
        0, 0, 17, 0, 0, 0, 0, 16, 0, 0, 0, 0, 15, 0, 0, 0,
        0, 0, 0, 17, 0, 0, 0, 16, 0, 0, 0, 15, 0, 0, 0, 0,
        0, 0, 0, 0, 17, 0, 0, 16, 0, 0, 15, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, 17, 0, 16, 0, 15, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, 0, 17, 16, 15, 0, 0, 0, 0, 0, 0, 0,
        1, 1, 1, 1, 1, 1, 1, 0, -1, -1, -1, -1, -1, -1, -1, 0,
        0, 0, 0, 0, 0, 0, -15, -16, -17, 0, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, -15, 0, -16, 0, -17, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, -15, 0, 0, -16, 0, 0, -17, 0, 0, 0, 0, 0,
        0, 0, 0, -15, 0, 0, 0, -16, 0, 0, 0, -17, 0, 0, 0, 0,
        0, 0, -15, 0, 0, 0, 0, -16, 0, 0, 0, 0, -17, 0, 0, 0,
        0, -15, 0, 0, 0, 0, 0, -16, 0, 0, 0, 0, 0, -17, 0, 0,
        -15, 0, 0, 0, 0, 0, 0, -16, 0, 0, 0, 0, 0, 0, -17
    ];

    const FLAGS = [
        'NORMAL' => 'n',
        'CAPTURE' => 'c',
        'BIG_PAWN' => 'b',
        'EP_CAPTURE' => 'e',
        'PROMOTION' => 'p',
        'KSIDE_CASTLE' => 'k',
        'QSIDE_CASTLE' => 'q'
    ];

    const FLAGS_NAMES = [
        'n' => 'normal',
        'c' => 'capture',
        'b' => 'big pawn',
        'e' => 'en passant',
        'p' => 'promotion',
        'k' => 'short castling',
        'q' => 'long castling'
    ];

    const BITS = [
        'NORMAL' => 1,
        'CAPTURE' => 2,
        'BIG_PAWN' => 4,
        'EP_CAPTURE' => 8,
        'PROMOTION' => 16,
        'KSIDE_CASTLE' => 32,
        'QSIDE_CASTLE' => 64
    ];

    const RANK_1 = 7;
    const RANK_2 = 6;
    const RANK_3 = 5;
    const RANK_4 = 4;
    const RANK_5 = 3;
    const RANK_6 = 2;
    const RANK_7 = 1;
    const RANK_8 = 0;


    const ROOKS = [
        self::WHITE => [
            [
                'square' => Board::SQUARES['a1'],
                'flag' => self::BITS['QSIDE_CASTLE']
            ],
            [
                'square' => Board::SQUARES['h1'],
                'flag' => self::BITS['KSIDE_CASTLE']
            ]
        ],
        self::BLACK => [
            [
                'square' => Board::SQUARES['a8'],
                'flag' => self::BITS['QSIDE_CASTLE']
            ],
            [
                'square' => Board::SQUARES['h8'],
                'flag' => self::BITS['KSIDE_CASTLE']
            ]
        ]
    ];


    protected Board $board;
    protected $kings;
    protected $turn;
    protected $castling;
    protected $epSquare;
    protected $halfMoves;
    protected $moveNumber;
    protected $history;
    protected $header;
    protected $generateMovesCache;

    public function __construct($fen = null)
    {
        $this->clear();

        if (strlen(strval($fen)) > 0) {
            $this->load(strval($fen));
        } else {
            $this->reset();
        }
    }

    /**
     * Reset game to start position
     */
    public function clear()
    {
        $this->board = new Board();
        $this->kings = [self::WHITE => null, self::BLACK => null];
        $this->turn = self::WHITE;
        $this->castling = [self::WHITE => 0, self::BLACK => 0];
        $this->epSquare = null;
        $this->halfMoves = 0;
        $this->moveNumber = 1;
        $this->history = [];
        $this->header = [];
        $this->generateMovesCache = [];

        for ($i = 0; $i < 120; ++$i) {
            $this->board->setSquare($i, null);
        }
    }

    /**
     * Update current game setup
     * @param $fen
     */
    protected function updateSetup($fen)
    {
        if (count($this->history) > 0) {
            return;
        }
        if ($fen !== self::DEFAULT_POSITION) {
            $this->header['SetUp'] = '1';
            $this->header['FEN'] = $fen;
        } else {
            unset($this->header['SetUp']);
            unset($this->header['FEN']);
        }
    }

    /**
     * Load game state from fen string
     * @param $fen
     * @return bool
     */
    public function load($fen)
    {
        if (!$fen) {
            $fen = self::DEFAULT_POSITION;
        }
        $tokens = explode(' ', $fen);
        $this->clear();

        // position
        $position = $tokens[0];
        $square = 0;
        for ($i = 0; $i < strlen($position); ++$i) {
            $piece = substr($position, $i, 1);
            if ($piece === '/') {
                $square += 8;
            } elseif (ctype_digit($piece)) {
                $square += intval($piece, 10);
            } else {
                $this->putPieceToBoard(ChessPieceGenerator::getChessPiece($piece), Board::integerSquareToAlgebraic($square));
                ++$square;
            }
        }

        // turn
        $this->turn = $tokens[1];

        // castling options
        if (strpos($tokens[2], 'K') !== false) {
            $this->castling[self::WHITE] |= self::BITS['KSIDE_CASTLE'];
        }
        if (strpos($tokens[2], 'Q') !== false) {
            $this->castling[self::WHITE] |= self::BITS['QSIDE_CASTLE'];
        }
        if (strpos($tokens[2], 'k') !== false) {
            $this->castling[self::BLACK] |= self::BITS['KSIDE_CASTLE'];
        }
        if (strpos($tokens[2], 'q') !== false) {
            $this->castling[self::BLACK] |= self::BITS['QSIDE_CASTLE'];
        }

        // ep square
        $this->epSquare = ($tokens[3] === '-') ? null : Board::SQUARES[$tokens[3]];

        // half moves
        $this->halfMoves = intval($tokens[4], 10);

        // move number
        $this->moveNumber = intval($tokens[5], 10);

        $this->updateSetup($this->generateFen());

        return true;
    }

    /**
     * Reset game to start position
     * @return bool
     */
    public function reset()
    {
        return $this->load(self::DEFAULT_POSITION);
    }

    /**
     * Generate fen string for current game state
     * @param bool $onlyPosition
     * @return string
     */
    public function generateFen($onlyPosition = false)
    {
        $empty = 0;
        $fen = '';
        for ($i = Board::SQUARES['a8']; $i <= Board::SQUARES['h1']; ++$i) {
            if ($this->board->getSquare($i) === null) {
                ++$empty;
            } else {
                if ($empty > 0) {
                    $fen .= $empty;
                    $empty = 0;
                }

                $fen .= $this->board->getSquare($i)->getSymbol();
            }

            if (($i + 1) & 0x88) {
                if ($empty > 0) {
                    $fen .= $empty;
                }
                if ($i !== Board::SQUARES['h1']) {
                    $fen .= '/';
                }
                $empty = 0;
                $i += 8;
            }
        }

        $cFlags = '';
        if ($this->castling[self::WHITE] & self::BITS['KSIDE_CASTLE']) {
            $cFlags .= 'K';
        }
        if ($this->castling[self::WHITE] & self::BITS['QSIDE_CASTLE']) {
            $cFlags .= 'Q';
        }
        if ($this->castling[self::BLACK] & self::BITS['KSIDE_CASTLE']) {
            $cFlags .= 'k';
        }
        if ($this->castling[self::BLACK] & self::BITS['QSIDE_CASTLE']) {
            $cFlags .= 'q';
        }
        if ($cFlags == '') {
            $cFlags = '-';
        }

        $epFlags = $this->epSquare === null ? '-' : Board::integerSquareToAlgebraic($this->epSquare);

        if ($onlyPosition) {
            return implode(' ', [$fen, $this->turn, $cFlags, $epFlags]);
        } else {
            return implode(' ', [$fen, $this->turn, $cFlags, $epFlags, $this->halfMoves, $this->moveNumber]);
        }
    }

    /**
     * Remove piece from board square
     * @param string $square algebraic representation of square
     * @return bool
     */
    public function remove($square)
    {
        // check for valid square
        if (!array_key_exists($square, Board::SQUARES)) {
            return false;
        }

        $piece = $this->board->getSquare($square);
        $this->board->setSquare(Board::SQUARES[$square], null);

        if ($piece) {
            if ($piece instanceof King) {
                $this->kings[$piece->getColor()] = null;
            }
        }

        $this->updateSetup($this->generateFen());

        return true;
    }

    /**
     * Put piece in board square
     * @param $piece
     * @param string $square algebraic representation of square
     * @return bool
     */
    public function putPieceToBoard(ChessPieceInterface $piece, $square)
    {
        // check for valid piece object
        if (!$piece) {
            return false;
        }

        // check for valid square
        if (!array_key_exists($square, $this->board::SQUARES)) {
            return false;
        }

        $integerSquare = $this->board::SQUARES[$square];

        // don't let the use place more than one king
        if ($piece instanceof King && !($this->kings[$piece->getColor()] == null || $this->kings[$piece->getColor()] == $integerSquare)) {
            return false;
        }

        $this->board->setSquare($integerSquare, $piece);
        if ($piece instanceof King) {
            $this->kings[$piece->getColor()] = $integerSquare;
        }

        $this->updateSetup($this->generateFen());

        return true;
    }

    /**
     * Build move array
     * @param $turn
     * @param $board
     * @param $from
     * @param $to
     * @param $flags
     * @param null $promotion
     * @return array
     */
    private function buildMove($turn, Board $board, $from, $to, $flags, $promotion = null)
    {
        $move = [
            'color' => $turn,
            'from' => $from,
            'to' => $to,
            'flags' => $flags,
            'piece' => $board->getSquare($from)->getSymbol()
        ];

        if ($promotion !== null) {
            $move['flags'] |= self::BITS['PROMOTION'];
            $move['promotion'] = $promotion;
        }

        if ($board->getSquare($to) !== null) {
            $move['captured'] = $board->getSquare($to)->getSymbol();
        } elseif ($flags & self::BITS['EP_CAPTURE']) {
            $move['captured'] = self::PAWN;
        }

        return $move;
    }

    /**
     * Make move
     * @param array $move
     */
    protected function makeMove(array $move)
    {
        $us = $this->turn();
        $them = self::swapColor($us);
        $historyKey = $this->recordMove($move);

        $this->board->setSquare($move['to'], $this->board->getSquare($move['from']));
        $this->board->setSquare($move['from'], null);

        // if flags:EP_CAPTURE (en passant), remove the captured pawn
        if ($move['flags'] & self::BITS['EP_CAPTURE']) {
            $this->board->setSquare($move['to'] + ($us == self::BLACK ? -16 : 16), null);
        }

        // if pawn promotion, replace with new piece
        if ($move['flags'] & self::BITS['PROMOTION']) {
            $this->board->setSquare($move['to'], ChessPieceGenerator::getChessPiece($move['promotion']));
        }

        // if big pawn move, update the en passant square
        if ($move['flags'] & self::BITS['BIG_PAWN']) {
            $this->epSquare = $move['to'] + ($us == self::BLACK ? -16 : 16);
        } else {
            $this->epSquare = null;
        }

        // reset the 50 move counter if a pawn is moved or piece is captured
        if ($move['piece'] === self::PAWN) {
            $this->halfMoves = 0;
        } elseif ($move['flags'] & (self::BITS['CAPTURE'] | self::BITS['EP_CAPTURE'])) {
            $this->halfMoves = 0;
        } else {
            ++$this->halfMoves;
        }

        // if we moved the king
        if ($this->board->getSquare($move['to']) instanceof King) {
            $this->kings[$us] = $move['to'];

            // if we castled, move the rook next to the king
            if ($move['flags'] & self::BITS['KSIDE_CASTLE'] || $move['flags'] & self::BITS['QSIDE_CASTLE']) {
                if ($move['flags'] & self::BITS['KSIDE_CASTLE']) {
                    $castlingTo = $move['to'] - 1;
                    $castlingFrom = $move['to'] + 1;
                } elseif ($move['flags'] & self::BITS['QSIDE_CASTLE']) {
                    $castlingTo = $move['to'] + 1;
                    $castlingFrom = $move['to'] - 2;
                }
                $this->board->setSquare($castlingTo, $this->board->getSquare($castlingFrom));
                $this->board->setSquare($castlingFrom, null);
            }


            $this->castling[$us] = 0; // or maybe ''
        }

        // turn of castling of we move a rock
        if ($this->castling[$us] > 0) {
            for ($i = 0, $len = count(self::ROOKS[$us]); $i < $len; ++$i) {
                if (
                    $move['from'] === self::ROOKS[$us][$i]['square'] &&
                    $this->castling[$us] & self::ROOKS[$us][$i]['flag']
                ) {
                    $this->castling[$us] ^= self::ROOKS[$us][$i]['flag'];
                    break;
                }
            }
        }

        // turn of castling of we capture a rock
        if ($this->castling[$them] > 0) {
            for ($i = 0, $len = count(self::ROOKS[$them]); $i < $len; ++$i) {
                if (
                    $move['to'] === self::ROOKS[$them][$i]['square'] &&
                    $this->castling[$them] & self::ROOKS[$them][$i]['flag']
                ) {
                    $this->castling[$them] ^= self::ROOKS[$them][$i]['flag'];
                    break;
                }
            }
        }


        if ($us === self::BLACK) {
            ++$this->moveNumber;
        }
        $this->turn = $them;

        //~ echo $historyKey . PHP_EOL;
        // needed caching for short inThreefoldRepetition()
        $this->history[$historyKey]['position'] = $this->generateFen(true);
    }

    /**
     * Record move in a history
     * @param array $move
     * @return int|string|null
     */
    protected function recordMove($move)
    {
        $this->history[] = [
            'move' => $move,
            'kings' => [
                self::WHITE => $this->kings[self::WHITE],
                self::BLACK => $this->kings[self::BLACK]
            ],
            'turn' => $this->turn(),
            'castling' => [
                self::WHITE => $this->castling[self::WHITE],
                self::BLACK => $this->castling[self::BLACK]
            ],
            'epSquare' => $this->epSquare,
            'halfMoves' => $this->halfMoves,
            'moveNumber' => $this->moveNumber,
        ];

        end($this->history);

        return key($this->history);
    }

    /**
     * Undo last move
     * @return array
     */
    protected function undoMove()
    {
        $old = array_pop($this->history);
        if ($old === null) {
            return null;
        }

        $move = $old['move'];
        $this->kings = $old['kings'];
        $this->turn = $old['turn'];
        $this->castling = $old['castling'];
        $this->epSquare = $old['epSquare'];
        $this->halfMoves = $old['halfMoves'];
        $this->moveNumber = $old['moveNumber'];

        $us = $this->turn;
        $them = self::swapColor($us);

        $this->board->setSquare($move['from'], $this->board->getSquare($move['to']));
        $this->board->setSquare($move['from'], ChessPieceGenerator::getChessPiece($move['piece'])); // to undo any promotions
        $this->board->setSquare($move['to'], null);

        // if capture
        if ($move['flags'] & self::BITS['CAPTURE']) {
            $this->board->setSquare($move['to'], ChessPieceGenerator::getChessPiece($move['captured']));
        } elseif ($move['flags'] & self::BITS['EP_CAPTURE']) {
            $index = $move['to'] + ($us == self::BLACK ? -16 : 16);
            $this->board->setSquare($index, ChessPieceGenerator::getChessPiece($them === 'b' ? 'p' : 'P'));
        }

        // if castling
        if ($move['flags'] & (self::BITS['KSIDE_CASTLE'] | self::BITS['QSIDE_CASTLE'])) {
            if ($move['flags'] & self::BITS['KSIDE_CASTLE']) {
                $castlingTo = $move['to'] + 1;
                $castlingFrom = $move['to'] - 1;
            } elseif ($move['flags'] & self::BITS['QSIDE_CASTLE']) {
                $castlingTo = $move['to'] - 2;
                $castlingFrom = $move['to'] + 1;
            }
            $this->board[$castlingTo] = $this->board[$castlingFrom];
            $this->board[$castlingFrom] = null;
        }

        return $move;
    }

    private function addMove($turn, Board $board, $moves, $from, $to, $flags)
    {
        // if pawn promotion
        if (
            $board->getSquare($from) instanceof Pawn &&
            (Board::rank($to) === self::RANK_8 || Board::rank($to) === self::RANK_1)
        ) {
            $promotionPieces = [self::QUEEN, self::ROOK, self::BISHOP, self::KNIGHT];
            foreach ($promotionPieces as $promotionPiece) {
                $moves[] = $this->buildMove($turn, $board, $from, $to, $flags, $promotionPiece);
            }
        } else {
            $moves[] = $this->buildMove($turn, $board, $from, $to, $flags);
        }

        return $moves;
    }

    /**
     * Generate possible moves
     * @param array $options
     * @return array
     */
    protected function generateMoves($options = [])
    {
        $cacheKey = $this->generateFen() . json_encode($options);

        // check cache first
        if (isset($this->generateMovesCache[$cacheKey])) {
            return $this->generateMovesCache[$cacheKey];
        }

        $moves = [];
        $us = $this->turn();
        $them = self::swapColor($us);
        $secondRank = [self::BLACK => self::RANK_7,
            self::WHITE => self::RANK_2];

        if (!empty($options['square'])) {
            $firstSquare = $lastSquare = $options['square'];
            $singleSquare = true;
        } else {
            $firstSquare = Board::SQUARES['a8'];
            $lastSquare = Board::SQUARES['h1'];
            $singleSquare = false;
        }

        // legal moves only?
        $legal = isset($options['legal']) ? $options['legal'] : true;

        // using anonymous function here, is it a bad practice?
        // its because we stick to use "self::", if its not anonymous, then it have to be "Chess::"


        for ($i = $firstSquare; $i <= $lastSquare; ++$i) {
            if ($i & 0x88) {
                $i += 7;
                continue;
            } // check edge of board

            $piece = $this->board->getSquare($i);
            if ($piece === null || $piece->getColor() !== $us) {
                continue;
            }

            if ($piece instanceof Pawn) {
                // single square, non-capturing
                $square = $i + $piece->getOffsets()[0];
                if ($this->board->getSquare($square) == null) {
                    $moves = $this->addMove($us, $this->board, $moves, $i, $square, self::BITS['NORMAL']);

                    // double square
                    $square = $i + $piece->getOffsets()[1];
                    if ($secondRank[$us] === Board::rank($i) && $this->board->getSquare($square) === null) {
                        $moves = $this->addMove($us, $this->board, $moves, $i, $square, self::BITS['BIG_PAWN']);
                    }
                }

                // pawn captures
                for ($j = 2; $j < 4; ++$j) {
                    $square = $i + $piece->getOffsets()[$j];
                    if ($square & 0x88) {
                        continue;
                    }
                    if ($this->board->getSquare($square) !== null) {
                        if ($this->board->getSquare($square)->getColor() === $them) {
                            $moves = $this->addMove($us, $this->board, $moves, $i, $square, self::BITS['CAPTURE']);
                        }
                    } elseif ($square === $this->epSquare) { // get epSquare from enemy
                        $moves = $this->addMove($us, $this->board, $moves, $i, $this->epSquare, self::BITS['EP_CAPTURE']);
                    }
                }
            } else {
                foreach ($piece->getOffsets() as $offset) {
                    $square = $i;

                    while (true) {
                        $square += $offset;
                        if ($square & 0x88) {
                            break;
                        }

                        if ($this->board->getSquare($square) === null) {
                            $moves = $this->addMove($us, $this->board, $moves, $i, $square, self::BITS['NORMAL']);
                        } else {
                            if ($this->board->getSquare($square)->getColor() === $us) {
                                break;
                            }
                            $moves = $this->addMove($us, $this->board, $moves, $i, $square, self::BITS['CAPTURE']);
                            break;
                        }

                        if ($piece instanceof Knight || $piece instanceof King) {
                            break;
                        }
                    }
                }
            }
        }

        // castling
        // a) we're generating all moves
        // b) we're doing single square move generation on king's square
        if (!$singleSquare || $lastSquare === $this->kings[$us]) {
            if ($this->castling[$us] & self::BITS['KSIDE_CASTLE']) {
                $castlingFrom = $this->kings[$us];
                $castlingTo = $castlingFrom + 2;

                if (
                    $this->board->getSquare($castlingFrom + 1) === null &&
                    $this->board->getSquare($castlingTo) === null &&
                    !$this->attacked($them, $this->kings[$us]) &&
                    !$this->attacked($them, $castlingFrom + 1) &&
                    !$this->attacked($them, $castlingTo)
                ) {
                    $moves = $this->addMove($us, $this->board, $moves, $this->kings[$us], $castlingTo, self::BITS['KSIDE_CASTLE']);
                }
            }

            if ($this->castling[$us] & self::BITS['QSIDE_CASTLE']) {
                $castlingFrom = $this->kings[$us];
                $castlingTo = $castlingFrom - 2;

                if (
                    $this->board->getSquare($castlingFrom - 1) == null &&
                    $this->board->getSquare($castlingFrom - 2) == null && // $castlingTo
                    $this->board->getSquare($castlingFrom - 3) == null && // col "b", next to rock
                    !$this->attacked($them, $this->kings[$us]) &&
                    !$this->attacked($them, $castlingFrom - 1) &&
                    !$this->attacked($them, $castlingTo)
                ) {
                    $moves = $this->addMove($us, $this->board, $moves, $this->kings[$us], $castlingTo, self::BITS['QSIDE_CASTLE']);
                }
            }
        }

        // return all pseudo-legal moves (this includes moves that allow the king to be captured)
        if (!$legal) {
            $this->generateMovesCache[$cacheKey] = $moves;

            return $moves;
        }

        // filter out illegal moves
        $legalMoves = [];
        foreach ($moves as $i => $move) {
            $this->makeMove($move);
            if (!$this->kingAttacked($us)) {
                $legalMoves[] = $move;
            }
            $this->undoMove();
        }

        $this->generateMovesCache[$cacheKey] = $legalMoves;

        return $legalMoves;
    }

    /**
     * Get possible moves for color that is on move now
     * @param bool $verbose
     * @return array
     */
    public function moves()
    {
        $moves = $this->generateMoves();
        array_walk($moves, function (&$move) {
            $move = $this->makePretty($move);
        });

        return $moves;
    }

    /**
     * Determine which color move is now
     * @return mixed
     */
    public function turn()
    {
        return $this->turn;
    }

    /**
     * Return full color name of moving side
     */
    public function turnFull()
    {
        return $this->turn() === self::BLACK ? 'black' : 'white';
    }

    /**
     * Check if square is under attack
     * @param $color
     * @param $square
     * @return bool
     */
    protected function attacked($color, $square)
    {
        for ($i = Board::SQUARES['a8']; $i <= Board::SQUARES['h1']; ++$i) {
            if ($i & 0x88) {
                $i += 7;
                continue;
            } // check edge of board

            if ($this->board->getSquare($i) === null) {
                continue;
            } // check empty square
            if ($this->board->getSquare($i)->getColor() !== $color) {
                continue;
            } // check color

            $piece = $this->board->getSquare($i);
            $difference = $i - $square;
            $index = $difference + 119;

            if (self::ATTACKS[$index] & (1 << $piece->getShift())) {
                if ($piece instanceof Pawn) {
                    if ($difference > 0) {
                        if ($piece->getColor() === self::WHITE) {
                            return true;
                        }
                    } else {
                        if ($piece->getColor() === self::BLACK) {
                            return true;
                        }
                    }
                    continue;
                }

                if ($piece instanceof Knight || $piece instanceof King) {
                    return true;
                }

                $offset = self::RAYS[$index];
                $j = $i + $offset;
                $blocked = false;
                while ($j !== $square) {
                    if ($this->board->getSquare($j) !== null) {
                        $blocked = true;
                        break;
                    }
                    $j += $offset;
                }

                if (!$blocked) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Determine if king is under attack
     * @param $color
     * @return bool
     */
    protected function kingAttacked($color)
    {
        return $this->attacked(self::swapColor($color), $this->kings[$color]);
    }

    /**
     * Check if game in check state
     * @return bool
     */
    public function inCheck()
    {
        return $this->kingAttacked($this->turn);
    }

    /**
     * Check if game in checkmate state
     * @return bool
     */
    public function inCheckmate()
    {
        return $this->inCheck() && count($this->generateMoves()) === 0;
    }

    /**
     * Check if game in stalemate state, which lead to draw state of game
     * @return bool
     */
    public function inStalemate()
    {
        return !$this->inCheck() && count($this->generateMoves()) === 0;
    }

    /**
     * Determine if game in insufficient material state, which lead to draw state of game
     * @return bool
     */
    public function insufficientMaterial()
    {
        $pieces = [
            Pawn::class => 0,
            Knight::class => 0,
            Bishop::class => 0,
            Rook::class => 0,
            Queen::class => 0,
            King::class=> 0,
        ];
        $bishops = null;
        $numPieces = 0;
        $sqColor = 0;

        for ($i = Board::SQUARES['a8']; $i <= Board::SQUARES['h1']; ++$i) {
            $sqColor = ($sqColor + 1) % 2;
            if ($i & 0x88) {
                $i += 7;
                continue;
            }

            $piece = $this->board->getSquare($i);
            if ($piece !== null) {
                $pieces[get_class($piece)] += 1;
                if ($piece instanceof Bishop) {
                    $bishops[] = $sqColor;
                }
                ++$numPieces;
            }
        }

        // k vs k
        if ($numPieces === 2) {
            return true;
        }

        // k vs kn / k vs kb
        if ($numPieces === 3 && ($pieces[Bishop::class] === 1 || $pieces[Knight::class] === 1)) {
            return true;
        }

        // k ?+ b vs k ?+ b
        if ($numPieces === $pieces[Bishop::class] + 2) {
            $sum = 0;
            $len = count($bishops);
            foreach ($bishops as $bishop) {
                $sum += $bishop;
            }
            if ($sum === 0 || $sum === $len) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if game in threefold repetition, which may lead to a draw state of game
     * @return bool
     */
    public function inThreefoldRepetition()
    {
        $hash = [];
        foreach ($this->history as $history) {
            if (isset($hash[$history['position']])) {
                ++$hash[$history['position']];
            } else {
                $hash[$history['position']] = 1;
            }

            if ($hash[$history['position']] >= 3) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if half moves exceeded
     * @return bool
     */
    public function halfMovesExceeded()
    {
        return $this->halfMoves >= 100;
    }

    /**
     * Determine if game in a draw state
     * @return bool
     */
    public function inDraw()
    {
        return
            $this->halfMovesExceeded() ||
            $this->inStalemate() ||
            $this->insufficientMaterial() ||
            $this->inThreefoldRepetition();
    }

    /**
     * Determine if game is over
     * @return bool
     */
    public function gameOver()
    {
        return $this->inDraw() || $this->inCheckmate();
    }


    /**
     * Swap passed color
     * @param $color
     * @return string
     */
    protected static function swapColor($color)
    {
        return $color == self::WHITE ? self::BLACK : self::WHITE;
    }

    /**
     * This function is used to uniquely identify ambiguous moves
     * @param $move
     * @return false|string
     */
    protected function getDisambiguator($move)
    {
        $moves = $this->generateMoves();

        $from = $move['from'];
        $to = $move['to'];
        $piece = $move['piece'];

        $ambiguities = 0;
        $sameRank = 0;
        $sameFile = 0;

        for ($i = 0, $len = count($moves); $i < $len; ++$i) {
            $ambiguityFrom = $moves[$i]['from'];
            $ambiguityTo = $moves[$i]['to'];
            $ambiguityPiece = $moves[$i]['piece'];

            /* if a move of the same piece type ends on the same to square, we'll
             * need to add a disambiguator to the algebraic notation
             */
            if (
                $piece === $ambiguityPiece &&
                $from !== $ambiguityFrom &&
                $to === $ambiguityTo
            ) {
                ++$ambiguities;
                if (Board::rank($from) === Board::rank($ambiguityFrom)) {
                    ++$sameRank;
                }
                if (Board::file($from) === Board::file($ambiguityFrom)) {
                    ++$sameFile;
                }
            }
        }

        if ($ambiguities > 0) {
            /* if there exists a similar moving piece on the same rank and file as
             * the move in question, use the square as the disambiguator
             */
            if ($sameRank > 0 && $sameFile > 0) {
                return Board::integerSquareToAlgebraic($from);
            }

            /* if the moving piece rests on the same file, use the rank symbol as the
             * disambiguator
             */
            if ($sameFile > 0) {
                return substr(Board::integerSquareToAlgebraic($from), 1, 1);
            }

            // else use the file symbol
            return substr(Board::integerSquareToAlgebraic($from), 0, 1);
        }

        return '';
    }

    /**
     * Convert a move from 0x88 to SAN
     * @param $move
     * @return string
     */
    protected function moveToSAN($move)
    {
        $output = '';
        if ($move['flags'] & self::BITS['KSIDE_CASTLE']) {
            $output = 'O-O';
        } elseif ($move['flags'] & self::BITS['QSIDE_CASTLE']) {
            $output = 'O-O-O';
        } else {
            $disambiguator = $this->getDisambiguator($move);

            // pawn e2->e4 is "e4", knight g8->f6 is "Nf6"
            if ($move['piece'] !== self::PAWN) {
                $output .= strtoupper($move['piece']) . $disambiguator;
            }

            // x on capture
            if ($move['flags'] & (self::BITS['CAPTURE'] | self::BITS['EP_CAPTURE'])) {
                // pawn e5->d6 is "exd6"
                if ($move['piece'] === self::PAWN) {
                    $output .= substr(Board::integerSquareToAlgebraic($move['from']), 0, 1);
                }

                $output .= 'x';
            }

            $output .= Board::integerSquareToAlgebraic($move['to']);

            // promotion example: e8=Q
            if ($move['flags'] & self::BITS['PROMOTION']) {
                $output .= '=' . strtoupper($move['promotion']);
            }
        }

        // check / checkmate
        $this->makeMove($move);
        if ($this->inCheck()) {
            $output .= count($this->generateMoves()) === 0 ? '#' : '+';
        }
        $this->undoMove();

        return $output;
    }

    /**
     * Make move element human readable
     * @param $uglyMove
     * @return mixed
     */
    protected function makePretty($uglyMove)
    {
        $move = $uglyMove;
        $move['to'] = Board::integerSquareToAlgebraic($move['to']);
        $move['from'] = Board::integerSquareToAlgebraic($move['from']);
        $move['pieceName'] = self::PIECES_NAMES[strtolower($move['piece'])];
        $move['color'] = $move['color'] === 'b' ? 'Black' : 'White';


        $flags = '';
        $flagsNames = '';
        foreach (self::BITS as $k => $v) {
            if (self::BITS[$k] & $move['flags']) {
                $flags .= self::FLAGS[$k];
                $flagsNames .= self::FLAGS_NAMES[self::FLAGS[$k]] . ' ';
            }
        }
        $move['flags'] = $flags;
        $move['flagsNames'] = $flagsNames;
        return $move;
    }

    public function __toString()
    {
        return $this->ascii();
    }

    public function ascii()
    {
        $s = '   +------------------------+' . PHP_EOL;
        for ($i = Board::SQUARES['a8']; $i <= Board::SQUARES['h1']; ++$i) {
            // display the rank
            if (Board::file($i) === 0) {
                $s .= ' ' . substr('87654321', Board::rank($i), 1) . ' |';
            }

            if ($this->board->getSquare($i) == null) {
                $s .= ' . ';
            } else {
                $piece = $this->board->getSquare($i)->getSymbol();
                $color = $this->board->getSquare($i)->getColor();
                $symbol = ($color === self::WHITE) ? strtoupper($piece) : strtolower($piece);

                $s .= ' ' . $symbol . ' ';
            }

            if (($i + 1) & 0x88) {
                $s .= '|' . PHP_EOL;
                $i += 8;
            }
        }
        $s .= '   +------------------------+' . PHP_EOL;
        $s .= '     a  b  c  d  e  f  g  h' . PHP_EOL;

        return $s;
    }
    public function boardMarkup()
    {
        $s = <<<BOARD
<table class="table">
    <tr><td></td><td>a</td><td>b</td><td>c</td><td>d</td><td>e</td><td>f</td><td>g</td><td>h</td><td></td></tr>
BOARD;
;
        for ($i = Board::SQUARES['a8']; $i <= Board::SQUARES['h1']; ++$i) {
            // display the rank
            if (Board::file($i) === 0) {
                $s .= '<tr><td>' . substr('87654321', Board::rank($i), 1) . '</td>';
            }

            if ($this->board->getSquare($i) == null) {
                $s .= '<td></td>';
            } else {
                $piece = $this->board->getSquare($i)->getSymbol();
                $color = $this->board->getSquare($i)->getColor();
                $symbol = ($color === self::WHITE) ? strtoupper($piece) : strtolower($piece);

                $s .= '<td> ' . $symbol . ' </td>';
            }

            if (($i + 1) & 0x88) {
                $s .= '<td>' . substr('87654321', Board::rank($i), 1) . '</td></tr>';
                $i += 8;
            }
        }

        $s .= '<tr><td></td><td>a</td><td>b</td><td>c</td><td>d</td><td>e</td><td>f</td><td>g</td><td>h</td><td></td></tr></table>';

        return $s;
    }

    public function boardArray()
    {
        $board = [];

        for ($i = Board::SQUARES['a8']; $i <= Board::SQUARES['h1']; ++$i) {
            // display the rank
            if (Board::file($i) === 0) {
                $rowNumber = substr('87654321', Board::rank($i), 1);
            }

            if ($this->board->getSquare($i) == null) {
                $board[$rowNumber][] = '';
            } else {
                $piece = $this->board->getSquare($i)->getSymbol();
                $color = $this->board->getSquare($i)->getColor();
                $symbol = ($color === self::WHITE) ? strtoupper($piece) : strtolower($piece);
                $board[$rowNumber][] = $symbol;
            }

            if (($i + 1) & 0x88) {
                $i += 8;
            }
        }


        return $board;
    }
}