import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContactFormInfoLineProps } from '../../../props/props';
import Link from '../../atoms/Link';
import LinkFA from '../../atoms/LinkFA';
import P from '../../atoms/Typography/P';
import { privacyNoticeUrl } from '../../component_helper';
import ErrorBoundary from '../../organisms/errorboundary';

const ContactFormInfoLine: React.FC<React.PropsWithChildren<ContactFormInfoLineProps>> = (
  props: ContactFormInfoLineProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <P>
          Sie haben Fragen? Sind interessiert an der Arbeit in der Freiwilligen Feuerwehr? Nutzen
          Sie das Kontaktformular! Bitte beachten Sie auch unsere{' '}
          <LinkFA href={privacyNoticeUrl} title="Datenschutzerklärung" /> für den Umgang mit Ihren
          Daten.
        </P>
      </Col>
    </Row>
  </ErrorBoundary>
);
export default ContactFormInfoLine;
