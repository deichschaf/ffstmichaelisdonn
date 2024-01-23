import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { DireStraitsProps } from '../../../props/props';
import GridBox from '../../molecules/GridBox';
import ErrorBoundary from '../../organisms/errorboundary';
import PhoneNumber from '../PhoneNumber';
import SVGIcon from '../SVGIcon';

const DireStraits: React.FC<React.PropsWithChildren<DireStraitsProps>> = (
  props: DireStraitsProps,
): JSX.Element => (
  <ErrorBoundary>
    <GridBox lable="Notrufnummer 112">
      <Row>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={12}>
          <PhoneNumber telephonenumber="112">
            <SVGIcon svg="SignEuropeNumber" alt="Notruf 112" className="picture" />
          </PhoneNumber>
        </Col>
        <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={12}>
          <p className="text">
            Wenn Sie in einer Notlage sind, dann ist die <strong>Notrufnummer 112</strong> der heiße
            Draht zu Rettungsdienst und Feuerwehr. Die Nummer ist <strong>kostenfrei</strong> aus
            allen deutschen Netzen und in vielen europäischen Ländern erreichbar. Sollten Sie diese
            Nummer wählen, dann sagen Sie, <strong>wer</strong> Sie sind,
            <strong>was wo</strong> passiert ist und <strong>wieviele</strong> Personen beteiligt
            sind. Nun warten Sie auf Hilfe, kümmern sich ggf. um betroffene Personen und
            <strong>weisen</strong> Sie Rettungsdienst bzw. Feuerwehr ein.
          </p>
        </Col>
      </Row>
    </GridBox>
  </ErrorBoundary>
);
export default DireStraits;
