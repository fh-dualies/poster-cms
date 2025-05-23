INSERT INTO
  USER (username, password, email, x, truth_social)
VALUES
  (
    'felixBlume',
    'qwertzu123',
    'theBoss@gmail.com',
    'theBossX',
    'theBossTruth'
  ),
  (
    'PapaPlatte',
    'verySecure123',
    'secretMail@gmail.com',
    'pClub',
    'pClubTruth'
  );

INSERT INTO
  POSTER (
    user_id,
    author,
    creation_date,
    main_headline,
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
    'Papa Platte',
    '2023-10-02',
    'Clip ban!',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr'
  );

INSERT INTO
  MEDIA (type, path)
VALUES
  ('image', 'src/static/images/image1.jpg'),
  ('image', 'src/static/images/image2.jpg');

INSERT INTO
  SECTION (
    poster_id,
    section_headline,
    section_text,
    media_id
  )
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
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
    1
  ),
  (
    2,
    'Introduction',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
    1
  ),
  (
    2,
    'Main Part',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
    1
  ),
  (
    2,
    'Conclusion',
    'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
    1
  );
