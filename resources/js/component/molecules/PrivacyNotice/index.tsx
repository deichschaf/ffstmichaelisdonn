import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { PrivacyNoticeProps } from '../../../props/props';
import DivCheckbox from '../../atoms/Form/DivCheckbox';
import Link from '../../atoms/Link';
import LinkFA from '../../atoms/LinkFA';
import RowHeadline from '../../atoms/RowHeadline';
import H4 from '../../atoms/Typography/H4';
import P from '../../atoms/Typography/P';
import { privacyNoticeUrl } from '../../component_helper';
import ErrorBoundary from '../../organisms/errorboundary';

const PrivacyNotice: React.FC<React.PropsWithChildren<PrivacyNoticeProps>> = (
  props: PrivacyNoticeProps,
): JSX.Element => (
  <ErrorBoundary>
    <RowHeadline label="Datenschutzhinweis" headlineSize="h6" />
    <Row>
      <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={1} className="center-text">
        <DivCheckbox setParentValue={props.setParentValue} />
      </Col>
      <Col xxl={11} xl={11} lg={11} md={11} sm={11} xs={11}>
        Mit dem Absenden dieses Formulars wird der{' '}
        <LinkFA href={privacyNoticeUrl} title="Datenschutzerklärung dieser Website" /> und der
        Speicherung der übermittelten Daten zugestimmt.
      </Col>
    </Row>
  </ErrorBoundary>
);
export default PrivacyNotice;
