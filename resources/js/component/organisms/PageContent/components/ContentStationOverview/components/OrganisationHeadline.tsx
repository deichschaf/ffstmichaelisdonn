import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { OrganisationHeadlineProps } from '../../../../../../props/props';
import H1 from '../../../../../atoms/Typography/H1';
import ErrorBoundary from '../../../../errorboundary';
import ContentHeadline from '../../ContentHeadline';
import ContentRow from '../../ContentRow';

const OrganisationHeadline: React.FC<React.PropsWithChildren<OrganisationHeadlineProps>> = (
  props: OrganisationHeadlineProps,
): JSX.Element => {
  if (typeof props.headline === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <ContentRow>
        <H1 label={props.headline} />
      </ContentRow>
    </ErrorBoundary>
  );
};
export default OrganisationHeadline;
