INSERT INTO
  users (username, password, email, x, truth_social)
VALUES
  (
    'felixblume',
    '$2y$12$2nMDdvCg12971E23cm.A5e99u2Ew2pwAXkXt4TjTLywPCgsyOUTnK',
    'theboss@mail.com',
    'theBossX',
    'theBossTruth'
  ),
  (
    'papalatte',
    '$2y$12$2nMDdvCg12971E23cm.A5e99u2Ew2pwAXkXt4TjTLywPCgsyOUTnK',
    'lattensohn@mail.com',
    'papalatteX',
    'ptruth'
  );

INSERT INTO
  posters (
    user_id,
    author,
    creation_date,
    headline,
    meta_data
  )
VALUES
  (
    1,
    'Felix Blume',
    '2023-10-01',
    'Bossaura',
    'Lorem ipsum dolor sit amet'
  ),
  (
    2,
    'Papaplatte',
    '2023-10-02',
    'Setz den Hoodie auf',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr'
  );

INSERT INTO
  medias (type, path, name, alt, size)
VALUES
  (
    'image',
    'images/placeholder.jpg',
    'Image 1',
    'Placeholder Image 1',
    1024
  ),
  (
    'image',
    'images/placeholder.jpg',
    'Image 2',
    'Placeholder Image 2',
    2048
  );

INSERT INTO
  medias (id, type, path, name, alt, size)
VALUES
  (
    -1,
    'image',
    'images/placeholder.jpg',
    'Default Image',
    'Placeholder Image Default',
    1024
  );

INSERT INTO
  sections (poster_id, headline, text, media_id)
VALUES
  (
    1,
    'Origin Story',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
    1
  ),
  (
    1,
    'Passion',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.',
    1
  ),
  (
    2,
    'Introduction',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.',
    1
  ),
  (
    2,
    'Main Part',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.',
    1
  ),
  (
    2,
    'Conclusion',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.',
    1
  );
