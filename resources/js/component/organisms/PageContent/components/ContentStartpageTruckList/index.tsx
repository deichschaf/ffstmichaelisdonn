import React from 'react';
import { Row } from 'react-bootstrap';
import { ContentStartpageTruckListProps } from '../../../../../props/props';
import NewsTruckCard from '../../../../molecules/NewsTruckCard';
import ErrorBoundary from '../../../errorboundary';

const ContentStartpageTruckList: React.FC<
  React.PropsWithChildren<ContentStartpageTruckListProps>
> = (props: ContentStartpageTruckListProps): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.verhicles === 'undefined') {
    return <></>;
  }
  const vehicle = props.data.verhicles;
  return (
    <ErrorBoundary>
      <Row>
        {vehicle.map((item, idx) => (
          <NewsTruckCard key={idx} data={item} />
        ))}
      </Row>
    </ErrorBoundary>
  );
};
export default ContentStartpageTruckList;
