INSERT INTO
  users (username, password, email, x, truth_social)
VALUES
  (
    'joesmith',
    '$2y$12$2nMDdvCg12971E23cm.A5e99u2Ew2pwAXkXt4TjTLywPCgsyOUTnK',
    'joesmith@mail.com',
    'joesmithX',
    'joesmithTruth'
  ),
  (
    'johndoe',
    '$2y$12$2nMDdvCg12971E23cm.A5e99u2Ew2pwAXkXt4TjTLywPCgsyOUTnK',
    'johndoe@mail.com',
    'johndoeX',
    'johndoeTruth'
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
    'Joe Smith',
    '2023-10-01',
    'Demo Poster 1',
    'Lorem ipsum dolor sit amet'
  ),
  (
    2,
    'John Doe',
    '2023-10-02',
    'Demo Poster 2',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr'
  );

INSERT INTO
  medias (type, path, name, alt, size)
VALUES
  (
    'image',
    'images/demo/demo-3.webp',
    'Image 1',
    'Placeholder Image 1',
    1024
  ),
  (
    'image',
    'images/demo/demo-4.webp',
    'Image 2',
    'Placeholder Image 2',
    2048
  );

INSERT INTO
  sections (
    poster_id,
    headline,
    text,
    media_id,
    section_index
  )
VALUES
  (
    1,
    'Origin Story',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
    1,
    1
  ),
  (
    1,
    'Passion',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.',
    1,
    2
  ),
  (
    2,
    'Introduction',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.',
    2,
    1
  ),
  (
    2,
    'Main Part',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.',
    2,
    2
  ),
  (
    2,
    'Conclusion',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.',
    2,
    3
  );
