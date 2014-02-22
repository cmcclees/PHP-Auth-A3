<?php
namespace ITP\Songs;


class SongQuery {
    protected $pdo;
    protected $sql;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->sql = "SELECT * FROM songs";
    }

    public function orderBy($type)
    {
        $this->sql .= " ORDER BY $type";
        return $this;
    }

    public function withArtist() {
        $this->sql .= " INNER JOIN artists ON songs.artist_id = artists.id";
        return $this;
    }
    public function withGenre() {
       $this->sql .= " INNER JOIN genres ON songs.genre_id = genres.id";
        return $this;
    }
    public function all()
    {
        $statement = $this->pdo->prepare($this->sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

}
