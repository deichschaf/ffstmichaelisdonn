import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FireDepartmentFireRegisterProps } from '../../../props/props';
import Link from '../../atoms/Link';
import LinkFA from '../../atoms/LinkFA';
import P from '../../atoms/Typography/P';
import ErrorBoundary from '../../organisms/errorboundary';

const FireDepartmentFireRegister: React.FC<
  React.PropsWithChildren<FireDepartmentFireRegisterProps>
> = (props: FireDepartmentFireRegisterProps): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <P>
          Seit 2009 müssen private Feuer nicht mehr beim Ordnungsamt angemeldet werden sondern bei
          der örtlichen Feuerwehr. Um diesen Prozess zu vereinfachen können Sie Ihr Feuer über
          dieses Formular online bei uns anmelden.
        </P>
        <P>
          Bitte nehmen Sie sich Zeit die{' '}
          <LinkFA href={props.href} title="Hinweise zum Verbrennen" target="_blank" /> sorgsam
          durchzulesen und füllen Sie das folgende Formular aus. Die Freiwillige Feuerwehr behält
          sich vor den Brandplatz vor Ort zu begutachten.
        </P>
        <P>
          Die Meldung des Feuers über dieses Formular wird nicht an die Feuerwehrleitstelle
          übermittelt. Im Fall einer Meldung durch Dritte kann es zu einem Ausrücken der Feuerwehr
          kommen.
        </P>
        <P>
          Bitte füllen Sie alle rot markierten Pflichtfelder aus und bestätigen Sie die
          Einverständniserklärung bevor Sie das Formular abschicken.
        </P>
        <P>
          Bitte melden Sie das Feuer bis spätestens <span className="error">4 Tage</span> vor dem
          abbrennen über dieses Formular an, danach bitte beim Wehrführer direkt anrufen.
        </P>
      </Col>
    </Row>
  </ErrorBoundary>
);
export default FireDepartmentFireRegister;
