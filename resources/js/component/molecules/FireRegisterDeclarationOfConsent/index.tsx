import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FireRegisterDeclarationOfConsentProps } from '../../../props/props';
import DivCheckbox from '../../atoms/Form/DivCheckbox';
import Link from '../../atoms/Link';
import LinkFA from '../../atoms/LinkFA';
import RowHeadline from '../../atoms/RowHeadline';
import H4 from '../../atoms/Typography/H4';
import P from '../../atoms/Typography/P';
import ErrorBoundary from '../../organisms/errorboundary';

const FireRegisterDeclarationOfConsent: React.FC<
  React.PropsWithChildren<FireRegisterDeclarationOfConsentProps>
> = (props: FireRegisterDeclarationOfConsentProps): JSX.Element => (
  <ErrorBoundary>
    <RowHeadline label="Einverständniserklärung*" headlineSize="h6" />
    <Row>
      <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={1} className="center-text">
        <DivCheckbox setParentValue={props.setParentValue} />
      </Col>
      <Col xxl={11} xl={11} lg={11} md={11} sm={11} xs={11}>
        Ich habe die <LinkFA href={props.href} title="Hinweise" target="_blank" /> gelesen und bin
        mir meiner Verantwortung bewusst und erkläre mich einverstanden:
      </Col>
    </Row>
  </ErrorBoundary>
);
export default FireRegisterDeclarationOfConsent;
