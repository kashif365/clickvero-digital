import ContactSection from '../components/sections/ContactSection';
import PageHero from '../components/sections/PageHero';
import Reasons from '../components/sections/Reasons';
import Icon from '../components/ui/Icon';
import Reveal from '../components/ui/Reveal';
import SectionHeading from '../components/ui/SectionHeading';
import { Skeleton } from '../components/ui/States';
import { aboutValues, disciplines, images } from '../content/site';
import { api } from '../lib/api';
import { useAsync } from '../lib/hooks';

function initials(name) {
    return name
        .split(' ')
        .map((part) => part[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();
}

/** Team members are managed in the admin panel; the grid is omitted while none are published. */
function Members() {
    const { data, loading } = useAsync((signal) => api.team(signal), []);
    const members = data?.data ?? [];

    if (!loading && members.length === 0) {
        return null;
    }

    return (
        <section className="py-12 md:py-20">
            <div className="container-site">
                <SectionHeading title="Meet the" accent="people behind the work" />
                <div className="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3 lg:grid-cols-4 lg:gap-6">
                    {loading
                        ? Array.from({ length: 4 }, (_, key) => <Skeleton key={key} className="aspect-[4/6] rounded-[24px]" />)
                        : members.map((member, index) => (
                              <Reveal
                                  as="figure"
                                  key={member.id}
                                  delay={(index % 4) * 70}
                                  className="group overflow-hidden rounded-[20px] border bg-card transition-colors duration-300 hover:border-brand/60 sm:rounded-[24px]"
                              >
                                  <div className="flex aspect-[4/5] items-center justify-center overflow-hidden bg-[#111111]">
                                      {member.photo ? (
                                          <img
                                              src={member.photo}
                                              alt={member.name}
                                              loading="lazy"
                                              className="size-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
                                          />
                                      ) : (
                                          <span className="text-5xl font-bold text-brand/40" aria-hidden="true">
                                              {initials(member.name)}
                                          </span>
                                      )}
                                  </div>
                                  <figcaption className="p-4 sm:p-5">
                                      <p className="font-bold sm:text-lg">{member.name}</p>
                                      <p className="text-sm text-brand">{member.role}</p>
                                      {member.bio && <p className="mt-2 hidden text-sm leading-relaxed text-muted-foreground sm:block">{member.bio}</p>}
                                  </figcaption>
                              </Reveal>
                          ))}
                </div>
            </div>
        </section>
    );
}

export default function Team() {
    return (
        <>
            <PageHero
                image={images.hero}
                eyebrow="Our team"
                title="A team built on real-world execution,"
                accent="not just ideas."
                text="A remote-first group of specialists in strategy, search, paid media, content, design, and development."
                breadcrumbs={[{ label: 'Team' }]}
            />

            <section className="py-12 md:py-20">
                <div className="container-site">
                    <SectionHeading
                        title="How the team"
                        accent="is organised"
                        text="Each engagement gets a lead strategist as your single point of contact, supported by specialists from the disciplines your plan needs."
                    />
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                        {disciplines.map((discipline, index) => (
                            <Reveal key={discipline.title} delay={index * 80} className="rounded-2xl border bg-card p-6 transition-colors hover:border-brand/60">
                                <span className="mb-5 flex size-12 items-center justify-center rounded-xl border border-brand/30 bg-brand/10 text-brand">
                                    <Icon name={discipline.icon} className="size-5" />
                                </span>
                                <h3 className="text-lg font-bold">{discipline.title}</h3>
                                <p className="mt-2 leading-relaxed text-muted-foreground">{discipline.text}</p>
                            </Reveal>
                        ))}
                    </div>
                </div>
            </section>

            <Members />
            <Reasons title="How we" accent="work together" items={aboutValues} />
            <ContactSection />
        </>
    );
}
