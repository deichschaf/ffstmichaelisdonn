import { Col, Row } from 'react-bootstrap';
import { RescueEliminateBailSaveProps } from '../../../../../../props/props';
import H2 from '../../../../../atoms/Typography/H2';
import GridSimple from '../../../../../molecules/GridSimple';
import ErrorBoundary from '../../../../errorboundary';
import { Link } from 'react-router-dom';

const EmergencyDetailPictureText: React.FC<
  React.PropsWithChildren<RescueEliminateBailSaveProps>
> = (props: RescueEliminateBailSaveProps): JSX.Element => (
  <ErrorBoundary>
    <GridSimple>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <H2 className="text-center" label="Wichtiger Hinweis!" />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <p>
            Auf unserer Internetseite berichten wir ausführlich (also auch mit Bildmaterial) über
            unser Einsatzgeschehen. Bilder werden erst gemacht, wenn das Einsatzgeschehen dies
            zulässt. Es werden keine Bilder von Verletzten oder Toten gemacht oder hier
            veröffentlicht. Sollte das veröffentlichte Bild Privateigentum und/oder Personen zeigen,
            wurde das schriftliche Einverständnis eingeholt. Der Berichtstext ist nicht
            rechtsverbindlich, sondern dient ausschließlich der Öffentlichkeitsarbeit.
          </p>
          <p>
            Sollten Sie Einwände gegen die hier veröffentlichen Fotos oder Berichte haben, wenden
            Sie sich bitte vertrauensvoll an <Link to="/kontakt">uns</Link>.
          </p>
        </Col>
      </Row>
    </GridSimple>
  </ErrorBoundary>
);
export default EmergencyDetailPictureText;
